<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Office;
use App\Schedule;
use Eliepse\Alert\AlertSuccess;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class ScheduleController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles:admin,manager');
        $this->authorizeResource(Schedule::class, 'schedule');
    }


    public function show(Schedule $schedule)
    {
        return view("models.schedule.show", compact("schedule"));
    }


    public function create(Office $office)
    {
        $classrooms = Classroom::all();

        return view('models.schedule.create', compact('office', 'classrooms'));
    }


    public function store(StoreScheduleRequest $request)
    {
        $schedule = new Schedule($request->all(['day', 'hour', 'start_at', 'end_at', 'signup_start_at',
            'signup_end_at', 'price', 'max_students']));

        $schedule->office()->associate($request->get('office'));
        $schedule->classroom()->associate($request->get('classroom'));

        // TODO(eliepse): add teachers

        $schedule->save();

        return redirect()->route('schedules.promptDuplicate', $schedule);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateScheduleRequest $request
     * @param Schedule $schedule
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->fill($request->all(['day', 'hour', 'start_at', 'end_at', 'signup_start_at',
            'signup_end_at', 'price', 'max_students']));
        $schedule->teachers()->sync($request->get('teachers', []));
        $schedule->save();

        if ($request->ajax())
            return response()->json([
                "alerts" => [
                    new AlertSuccess("Lesson updated."),
                ],
            ]);

        return redirect(route('lessons.index'));
    }
}
