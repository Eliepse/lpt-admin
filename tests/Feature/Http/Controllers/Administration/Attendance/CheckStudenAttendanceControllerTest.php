<?php

namespace Tests\Feature\Http\Controllers\Administration\Attendance;

use App\Attendance;
use App\Http\Controllers\Administration\Attendance\CheckStudentAttendanceController;
use App\Schedule;
use App\Student;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckStudenAttendanceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function action_not_allowed()
    {
        $this->markTestSkipped("Every staff member can manage attendances for now.");
    }

    /**
     * @test
     */
    public function list_view()
    {
        $manager = $this->createAdmin();
        $schedule = factory(Schedule::class)->create();

        $response = $this->actingAs($manager, 'admin')
            ->get(action([CheckStudentAttendanceController::class, 'list'],
                ['schedule' => $schedule, 'date' => '2019-01-01']));

        $response->assertStatus(200);
        $response->assertViewIs("models.schedule.attendances");
    }

    /**
     * @test
     */
    public function abort_on_bad_date_format()
    {
        $manager = $this->createAdmin();
        $schedule = factory(Schedule::class)->create();

        $response = $this->actingAs($manager, 'admin')
            ->get(action([CheckStudentAttendanceController::class, 'list'],
                ['schedule' => $schedule, 'date' => '2019']));

        $response->assertStatus(400);
    }

    /**
     * @test
     */
    public function specific_date_list_view()
    {
        $manager = $this->createAdmin();
        $schedule = factory(Schedule::class)->create();

        $response = $this->actingAs($manager, 'admin')
            ->get(action([CheckStudentAttendanceController::class, 'list'],
                [$schedule, Carbon::yesterday()->format('Y-m-d')]));

        $response->assertStatus(200);
        $response->assertViewIs("models.schedule.attendances");
    }

    /**
     * @test
     */
    public function check_create_new_entry()
    {
        $manager = $this->createManager();
        $schedule = factory(Schedule::class)->create();
        $schedule->subscribe($student = factory(Student::class)->create());

        $response = $this->actingAs($manager, 'admin')
            ->post(action([CheckStudentAttendanceController::class, 'check'], [$schedule, $student]), [
                'state' => $state = Attendance::STATE_PRESENT,
                'referred_date' => $referred_date = Carbon::today(),
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(action([CheckStudentAttendanceController::class, 'list'],
            ['schedule' => $schedule, 'date' => $referred_date->format('Y-m-d')]));
        $this->assertDatabaseHas('attendances', [
            'attendable_id' => $student->id,
            'attendable_type' => Student::class,
            'schedule_id' => $schedule->id,
            'state' => $state,
            'referred_date' => $referred_date
        ]);
    }

    /**
     * @test
     */
    public function check_update_existing_entry()
    {
        $manager = $this->createManager();
        $schedule = factory(Schedule::class)->create();
        $schedule->subscribe($student = factory(Student::class)->create());

        $this->actingAs($manager, 'admin')
            ->post(action([CheckStudentAttendanceController::class, 'check'], [$schedule, $student]), [
                'state' => Attendance::STATE_ABSENT,
                'referred_date' => $referred_date = Carbon::today(),
                'comment' => null
            ]);

        $response = $this->actingAs($manager, 'admin')
            ->post(action([CheckStudentAttendanceController::class, 'check'], [$schedule, $student]), [
                'state' => $state = Attendance::STATE_LATE,
                'referred_date' => $referred_date,
                'comment' => $comment = 'No bus available'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(action([CheckStudentAttendanceController::class, 'list'],
            ['schedule' => $schedule, 'date' => $referred_date->format('Y-m-d')]));
        $this->assertDatabaseHas('attendances', [
            'attendable_id' => $student->id,
            'attendable_type' => Student::class,
            'schedule_id' => $schedule->id,
            'state' => $state,
            'referred_date' => $referred_date,
            'comment' => $comment
        ]);
    }
}
