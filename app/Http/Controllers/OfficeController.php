<?php

namespace App\Http\Controllers;

use App\Enums\DaysEnum;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Office;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Office::class, 'office');
    }


    public function index()
    {
        $officies = Office::all();

        return view("models.office.index", compact("officies"));
    }


    public function create()
    {
        return view("models.office.create");
    }


    public function store(StoreOfficeRequest $request)
    {
        $office = new Office($request->all(['name']));
        $office->save();

        return redirect()->route('offices.index');
    }


    /**
     * Display the specified resource.
     *
     * @param Office $office
     *
     * @return Response
     */
    public function show(Office $office)
    {
        $schedules = $office->activeSchedules()
            ->with(['course.lessons'])
            ->get();

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

        return view('models.office.show', [
            'office' => $office,
            'days' => $days,
            'min' => $min,
            'max' => $max,
        ]);
    }


    /**
     * @param Office $office
     *
     * @return Factory|View
     */
    public function edit(Office $office)
    {
        return view("models.office.edit", ['office' => $office]);
    }


    /**
     * @param UpdateOfficeRequest $request
     * @param Office $office
     *
     * @return RedirectResponse
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $office->fill($request->only(["name", "postal_address"]));
        $office->save();

        return redirect()->route('offices.show', $office);
    }
}
