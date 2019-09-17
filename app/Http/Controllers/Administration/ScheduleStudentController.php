<?php


namespace App\Http\Controllers\Administration;


use App\Http\Requests\LinkStudentToScheduleRequest;
use App\Pivots\StudentSchedule;
use App\Schedule;
use App\Student;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ScheduleStudentController extends Controller
{
    use AuthorizesRequests;


    public function __construct()
    {
        $this->middleware("auth:admin");
    }


    /**
     * @param Schedule $schedule
     *
     * @return View
     * @throws AuthorizationException
     */
    public function select(Schedule $schedule)
    {
        $this->authorize('updateStudents', $schedule);

        $students = Student::query()
            ->whereNotIn('id', $schedule->students->pluck('id'))
            ->get();

        return view("models.schedule.select-student", compact("schedule", "students"));
    }


    /**
     * @param LinkStudentToScheduleRequest $request
     * @param Schedule $schedule
     * @param Student $student
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function link(LinkStudentToScheduleRequest $request, Schedule $schedule, Student $student)
    {
        $this->authorize('updateStudents', $schedule);

        if (!$schedule->students->containsStrict('id', $student->id)) {
            $schedule->subscribe($student);

            return redirect()->action([ScheduleStudentController::class, 'edit'], [$schedule, $student]);
        }

        $schedule->updateSubscription($student, $request->only(['price', 'paid']));

        return redirect()->route('schedules.show', $schedule);
    }


    /**
     * @param Schedule $schedule
     * @param Student $student
     *
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Schedule $schedule, Student $student)
    {
        $this->authorize('updateStudents', $schedule);

        // Abort if the student and the schedule does not belongs together
        if (!$subscription = $schedule->findSubscription($student))
            return abort(404);

        return view("models.schedule.edit-student", compact("schedule", "student", "subscription"));
    }
}
