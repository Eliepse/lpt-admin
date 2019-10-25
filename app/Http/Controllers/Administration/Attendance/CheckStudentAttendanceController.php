<?php


namespace App\Http\Controllers\Administration\Attendance;


use App\Attendance;
use App\Http\Requests\CheckStudentAttendanceRequest;
use App\Schedule;
use App\Student;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckStudentAttendanceController
{
    use AuthorizesRequests,
        ValidatesRequests;

    /**
     * @param Request $request
     * @param Schedule $schedule
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function list(Request $request, Schedule $schedule)
    {
        $this->authorize('checkStudentAttendance', $schedule);
        $date = $request->get('date');

        if (is_string($date) && !Carbon::hasFormat($date, 'Y-m-d')) {
            abort(400, 'The value of the "date" attribute has a bad format. Should be "Y-m-d"');
        }

        $referred_date = is_string($date) ? Carbon::createFromFormat("Y-m-d", $date) : Carbon::today();

        $students = $schedule->students;

        $attendances = $schedule->attendances()
            ->where('referred_date', $referred_date)
            ->where('attendable_type', Student::class)
            ->with(['attendable'])
            ->get();

        return view("models.schedule.attendances", [
            'schedule' => $schedule,
            'attendances' => $attendances,
            'students' => $students,
            'referred_date' => $referred_date
        ]);
    }

    /**
     * @param CheckStudentAttendanceRequest $request
     * @param Schedule $schedule
     * @param Student $student
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function check(CheckStudentAttendanceRequest $request, Schedule $schedule, Student $student)
    {
        $this->authorize('checkStudentAttendance', $schedule);

        // Does the student is really in this schedule ?
        if (!$student->is($schedule->students->firstWhere('id', $student->id))) {
            abort(400);
        }

        if ($request->has('referred_day')) {
            $referred_date = Carbon::createFromFormat('Y-m-d', $request->get('referred_date'));
        } else {
            $referred_date = Carbon::today();
        }

        /** @var Attendance $attendance */
        $attendance = $schedule->attendances()
            ->with(['attendable'])
            ->firstOrNew([
                'referred_date' => $referred_date,
                'attendable_id' => $student->id,
                'attendable_type' => Student::class,
            ]);

        $attendance->state = $request->get('state');
        $attendance->comment = $request->get('comment');
        $attendance->attendable()->associate($student);
        $attendance->save();

        return redirect()
            ->action([static::class, 'list'], ['schedule' => $schedule, 'date' => $referred_date->toDateString()]);
    }
}