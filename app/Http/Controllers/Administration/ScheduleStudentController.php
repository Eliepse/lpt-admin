<?php


namespace App\Http\Controllers\Administration;


use App\Http\Requests\LinkStudentToScheduleRequest;
use App\Pivots\StudentSchedule;
use App\Schedule;
use App\Student;
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

        $pivot = new StudentSchedule([
            'paid' => $request->get('paid', 0),
            'price' => $request->get('price', $schedule->price),
        ]);

        if (!$schedule->students->containsStrict('id', $student->id)) {
            $schedule->students()->attach($student->id, $pivot->getAttributes());
            $schedule->save();

            return redirect()->action([ScheduleStudentController::class, 'edit'], [$schedule, $student]);
        }

        $schedule->students()->updateExistingPivot($student->id, $pivot->getAttributes());
        $schedule->save();

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

        // Find student from schedule to have the associated pivot attributes
        $student = $schedule->students->firstWhere('id', $student->id);

        return view("models.schedule.edit-student", compact("schedule", "student"));
    }
}
