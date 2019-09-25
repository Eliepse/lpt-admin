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
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Campus::class, 'campus');
    }


    public function index()
    {
        $campuses = Campus::all();

        return view("models.campus.index", compact("campuses"));
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
     * @param Campus $campus
     *
     * @return Response
     */
    public function show(Campus $campus)
    {
        $schedules = $campus->getActiveSchedules()
            ->loadMissing(['course.lessons']);

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
}
