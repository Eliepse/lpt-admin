<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Office;
use App\Schedule;
use Eliepse\Alert\Alert;
use Eliepse\Alert\AlertSuccess;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

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
        $courses = Course::all();

        return view('models.schedule.create', compact('office', 'courses'));
    }


    public function store(StoreScheduleRequest $request)
    {
        $schedule = new Schedule($request->all(['room', 'day', 'hour', 'start_at', 'end_at', 'signup_start_at',
            'signup_end_at', 'price', 'max_students']));

        $schedule->office()->associate($request->get('office'));
        $schedule->course()->associate($request->get('course'));

        // TODO(eliepse): add teachers

        $schedule->save();

        return redirect()
            ->route('schedules.promptDuplicate', $schedule)
            ->with('alerts', [
                new AlertSuccess('La classe a été ajoutée.'),
            ]);
    }


    public function edit(Schedule $schedule)
    {
        return view("models.schedule.edit", ['schedule' => $schedule, 'office' => $schedule->office]);
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
        $schedule->fill($request->all(['room', 'day', 'hour', 'start_at', 'end_at',
            'signup_start_at', 'signup_end_at', 'price', 'max_students']));
        $schedule->teachers()->sync($request->get('teachers', []));
        $schedule->save();

        if ($request->ajax())
            return response()->json([
                "alerts" => [
                    new AlertSuccess("Class updated."),
                ],
            ]);

        return redirect()
            ->route('schedules.show', $schedule)
            ->with('alerts', [
                new AlertSuccess('La classe a été modifée.'),
            ]);
    }


    /**
     * @param Schedule $schedule
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function delete(Schedule $schedule)
    {
        $this->authorize("delete", $schedule);

        return view("models.schedule.delete", ["schedule" => $schedule]);
    }


    /**
     * @param Schedule $schedule
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function trash(Schedule $schedule)
    {
        $this->authorize("delete", $schedule);

        $schedule->delete();

        return redirect()
            ->route('dashboard')
            ->with('alerts', [
                new Alert('La classe a été supprimée.'),
            ]);
    }
}
