<?php

namespace App\Http\Controllers;

use App\Enums\DaysEnum;
use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;
use App\Campus;
use App\Schedule;
use Carbon\Carbon;
use Eliepse\Alert\AlertSuccess;
use Eliepse\Charts\DayGantt\GanttDayChart;
use Eliepse\Charts\HeatWeekCalendar\HeatWeekCalendar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->authorizeResource(Campus::class, 'campus');
    }


    public function index()
    {
        $campuses = Campus::with(['schedules.course.lessons'])->get();

        $heatmaps = $campuses
            ->keyBy('id')
            ->map(function (Campus $campus) {
                $heatmap = new HeatWeekCalendar();
                $campus->getActiveSchedules()
                    ->each(function (Schedule $schedule) use ($heatmap) {
                        $heatmap->add(
                            $schedule->day, ($schedule->hour->hour * 60) + $schedule->hour->minute,
                            $schedule->course->getDuration()
                        );
                    });

                return $heatmap;
            });

        return view('models.campus.index', ['campuses' => $campuses, 'heatmaps' => $heatmaps]);
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
     * @param GanttDayChart $days
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
//        $min = $schedules->min(function (Schedule $schedule) { return $schedule->hour; });
//        $min = $min && $min->isBefore(Carbon::createFromTime(10)) ? $min : Carbon::createFromTime(10);

        /** @var Carbon $max */
//        $max = $schedules->max(function (Schedule $schedule) { return $schedule->hour; });
//        $max = $max && $max->isAfter(Carbon::createFromTime(18)) ? $max : Carbon::createFromTime(18);

        $days = $schedules
//            ->sortBy('hour')
            ->groupBy('day')
            ->sortBy(function ($collec, $key) {
                return DaysEnum::getValue($key);
            })
            ->map(function (Collection $schedules) {
                $day = new GanttDayChart(8 * 60, 19 * 60);

                foreach ($schedules as $schedule) {
                    $day->add($schedule);
                }

                return $day;
            });

        return view('models.campus.show', [
            'campus' => $campus,
            'days' => $days,
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
}
