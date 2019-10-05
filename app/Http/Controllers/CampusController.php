<?php

namespace App\Http\Controllers;

use App\Enums\DaysEnum;
use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;
use App\Campus;
use App\Schedule;
use Carbon\Carbon;
use Eliepse\Alert\AlertSuccess;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CampusController extends Controller
{
    /**
     * Represent the stats interval in hours
     *
     * @var int
     */
    private $statsGranularity = 1;

    /**
     * Day "start at" and "end at" values
     *
     * @var array
     */
    private $dayBoundaries = [8, 20];

    /**
     * @var int
     */
    private $activityLevels = 3;


    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->authorizeResource(Campus::class, 'campus');
    }


    public function index()
    {
        $campuses = Campus::with(['schedules.course.lessons'])->get();

        $stats = $campuses
            ->keyBy('id')
            ->map(function (Campus $campus) {
                return $this->campusActivityStats($campus);
            });

        return view('models.campus.index', ['campuses' => $campuses, 'stats' => $stats]);
    }


    public function create()
    {
        return view("models.campus.create");
    }


    public function store(StoreCampusRequest $request)
    {
        $campus = new Campus($request->all(['name']));
        $campus->save();

        return redirect()
            ->route('campuses.index')
            ->with('alerts', [
                new AlertSuccess('Le campus a été ajouté.'),
            ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Campus $campus
     *
     * @return Response
     */
    public function show(Request $request, Campus $campus)
    {
        switch ($request->get('filter', 'active')) {
            case 'next':
                $schedules = $campus->getNextSchedules();
                break;
            default:
                $schedules = $campus->getActiveSchedules();
        }

        $schedules->loadMissing(['course.lessons']);

        /** @var Carbon $min */
        $min = $schedules->min(function (Schedule $schedule) { return $schedule->hour; });
        $min = $min && $min->isBefore(Carbon::createFromTime(10)) ? $min : Carbon::createFromTime(10);

        /** @var Carbon $max */
        $max = $schedules->max(function (Schedule $schedule) { return $schedule->hour; });
        $max = $max && $max->isAfter(Carbon::createFromTime(18)) ? $max : Carbon::createFromTime(18);

        $days = $schedules
            ->sortBy('hour')
            ->groupBy('day')
            ->sortBy(function ($coll, $key) {
                return DaysEnum::getValue($key);
            })
            ->map(function (Collection $schedules) {
                return $schedules->groupBy(function (Schedule $schedule) {
                    return $schedule->hour->hour;
                });
            });

        return view('models.campus.show', [
            'campus' => $campus,
            'days' => $days,
            'min' => $min,
            'max' => $max,
        ]);
    }


    /**
     * @param Campus $campus
     *
     * @return Factory|View
     */
    public function edit(Campus $campus)
    {
        return view("models.campus.edit", ['campus' => $campus]);
    }


    /**
     * @param UpdateCampusRequest $request
     * @param Campus $campus
     *
     * @return RedirectResponse
     */
    public function update(UpdateCampusRequest $request, Campus $campus)
    {
        $campus->fill($request->only(["name", "postal_address"]));
        $campus->save();

        return redirect()
            ->route('campuses.show', $campus)
            ->with('alerts', [
                new AlertSuccess('Le campus a été modifié.'),
            ]);
    }


    private function campusActivityStats(Campus $campus): Collection
    {
        $hoursStats = collect();
        $min = 0;
        $max = $this->activityLevels - 1;

        for ($h = $this->dayBoundaries[0]; $h <= $this->dayBoundaries[1]; $h += $this->statsGranularity) {

            $hourStats = $campus
                ->getActiveSchedules()
                ->filter(function (Schedule $schedule) use ($h) {
                    $end_at = $schedule->hour->hour + ($schedule->duration / 60);

                    return $schedule->hour->hour <= $h && $end_at >= $h + $this->statsGranularity;
                })
                ->groupBy('day')
                ->map(function (Collection $day) use (&$min, &$max) {
                    $count = $day->count();

                    $min = $min === 0 ? $count : min($min, $count);
                    $max = max($max, $count);

                    return $count;
                });

            $hoursStats->put($h, $hourStats);
        }

        $levelsDelta = max(1, ($max - $min) / $this->activityLevels);

        // We change to levels of activity to show off the most active periods
        $hoursStats->transform(function (Collection $hours) use ($min, $max, $levelsDelta) {
            return $hours->map(function (int $count) use ($min, $max, $levelsDelta) {
                for ($level = $this->activityLevels - 1; $level > 0; $level--) {
                    if ($count >= $min + ($level * $levelsDelta)) {
                        return $level;
                    }
                }

                return 0;
            });
        });

        return $hoursStats;
    }
}
