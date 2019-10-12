<?php

namespace Tests\Unit;

use App\Attendance;
use App\Schedule;
use App\Student;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    private function makeAttendance($attributes = []): Attendance
    {
        return new Attendance(array_merge([
            'schedule_id' => 0,
            'attendable_id' => 0,
            'attendable_type' => '',
            'referred_date' => Carbon::today(),
            'state' => Attendance::STATE_PRESENT,
        ], $attributes));
    }

    private function createAttendanceOfState(Schedule $schedule, Student $student, string $state, int $subWeeks = 0): Attendance
    {
        $attendance = $this->makeAttendance([
            'referred_date' => Carbon::today()->subWeeks($subWeeks),
            'state' => $state,
        ]);
        $attendance->attendable()->associate($student);
        $attendance->schedule()->associate($schedule);
        $attendance->save();

        return $attendance;
    }

    /**
     * @test
     */
    public function cast_referred_date()
    {
        $attendance = $this->makeAttendance();
        $attendance->referred_date = Carbon::createFromFormat('Y-m-d', $date = '2019-10-10');
        $attendance->save();
        $attendance->refresh();

        $this->assertDatabaseHas('attendances', ['referred_date' => $date]);
        $this->assertTrue(is_a($attendance->referred_date, CarbonInterface::class));
        $this->assertTrue($attendance->referred_date->is($date));
    }

    /**
     * @test
     */
    public function attendable_relation()
    {
        $attendance = $this->makeAttendance();
        $attendance->attendable()->associate($attendable = factory(Student::class)->create());
        $attendance->save();
        $attendance->refresh();
        $attendance->load(['attendable']);

        $this->assertDatabaseHas('attendances', [
            'attendable_id' => $attendable->id,
            'attendable_type' => Student::class,
        ]);
        $this->assertTrue($attendable->is($attendance->attendable));
    }

    /**
     * @test
     */
    public function schedule_relation()
    {
        $attendance = $this->makeAttendance();
        $attendance->schedule()->associate($schedule = factory(Schedule::class)->create());
        $attendance->save();
        $attendance->refresh();
        $attendance->load(['schedule']);

        $this->assertDatabaseHas('attendances', [
            'schedule_id' => $schedule->id,
        ]);
        $this->assertTrue($schedule->is($attendance->schedule));
    }

    /**
     * @test
     */
    public function scope_schedule_attendances()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();
        $students = factory(Student::class, 3)->create();

        foreach ($students as $student) {
            $schedule->subscribe($student);
            $this->createAttendanceOfState($schedule, $student, Attendance::STATE_PRESENT);
        }

        $this->assertEquals(3, Attendance::ofSchedule($schedule)->count());
    }

    /**
     * @test
     */
    public function scope_student_attendances()
    {
        $schedules = factory(Schedule::class, 3)->create();
        $student = factory(Student::class)->create();

        /** @var Schedule $schedule */
        foreach ($schedules as $schedule) {
            $schedule->subscribe($student);
            $this->createAttendanceOfState($schedule, $student, Attendance::STATE_PRESENT);
        }

        $this->assertEquals(3, Attendance::ofStudent($student)->count());
    }

    /**
     * @test
     */
    public function scope_student_and_schedule()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();
        $student = factory(Student::class)->create();

        $schedule->subscribe($student);

        for ($i = 0; $i < 3; $i++) {
            $this->createAttendanceOfState($schedule, $student, Attendance::STATE_PRESENT, $i);
        }

        $this->assertEquals(3, Attendance::ofSchedule($schedule)->ofStudent($student)->count());
    }

    /**
     * @test
     */
    public function scope_state_attendances()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();
        $student = factory(Student::class)->create();

        $schedule->subscribe($student);

        // Make some PRESENT attendances
        for ($i = 0; $i < 2; $i++) {
            $this->createAttendanceOfState($schedule, $student, Attendance::STATE_PRESENT, $i);
        }

        // Make some ABSENT attendances
        for ($i = 0; $i < 3; $i++) {
            $this->createAttendanceOfState($schedule, $student, Attendance::STATE_ABSENT, $i);
        }

        // Make some LATE attendances
        for ($i = 0; $i < 4; $i++) {
            $this->createAttendanceOfState($schedule, $student, Attendance::STATE_LATE, $i);
        }

        $this->assertEquals(2, Attendance::ofState(Attendance::STATE_PRESENT)->count());
        $this->assertEquals(3, Attendance::ofState(Attendance::STATE_ABSENT)->count());
        $this->assertEquals(4, Attendance::ofState(Attendance::STATE_LATE)->count());
    }

    /**
     * @test
     */
    public function scope_schedule_student_state_attendances()
    {
        /** @var Schedule $schedule */
        $schedules = factory(Schedule::class, 2)->create();
        $students = factory(Student::class, 2)->create();

        foreach ($schedules as $schedule) {
            foreach ($students as $student) {
                $schedule->subscribe($student);
                for ($i = 0; $i < 2; $i++) {
                    $this->createAttendanceOfState($schedule, $student, Attendance::STATE_PRESENT);
                }
                for ($i = 0; $i < 3; $i++) {
                    $this->createAttendanceOfState($schedule, $student, Attendance::STATE_ABSENT);
                }
                for ($i = 0; $i < 4; $i++) {
                    $this->createAttendanceOfState($schedule, $student, Attendance::STATE_LATE);
                }
            }
        }

        $this->assertEquals(2, Attendance::ofSchedule($schedules[0])
            ->ofStudent($students[0])
            ->ofState(Attendance::STATE_PRESENT)
            ->count());

        $this->assertEquals(3, Attendance::ofSchedule($schedules[0])
            ->ofStudent($students[1])
            ->ofState(Attendance::STATE_ABSENT)
            ->count());

        $this->assertEquals(4, Attendance::ofSchedule($schedules[1])
            ->ofStudent($students[0])
            ->ofState(Attendance::STATE_LATE)
            ->count());
    }
}
