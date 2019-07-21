<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Enums\LocationEnum;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Schedule;
use App\Sets\DaysSet;
use App\Student;
use Eliepse\Alert\AlertError;
use Eliepse\Alert\AlertSuccess;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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


    /**
     * Update the specified resource in storage.
     *
     * @param StoreScheduleRequest $request
     * @param Schedule $schedule
     *
     * @return RedirectResponse|Redirector
     */
    public function update(StoreScheduleRequest $request, Schedule $schedule)
    {
        $schedule->fill($request->all());
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
