<?php

namespace Tests\Feature\Http\Controllers\Administration;

use App\Classroom;
use App\Schedule;
use App\Sets\UserRolesSet;
use App\StaffUser;
use App\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleStudentControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testSelect()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $schedule = factory(Schedule::class)->create();
        $student = factory(Student::class)->create();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('schedules.students.select', $schedule));

        $response->assertStatus(200);
        $response->assertViewIs('models.schedule.select-student');
    }


    public function testLink()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $schedule = factory(Schedule::class)->create();
        $student = factory(Student::class)->create();

        $response = $this->actingAs($admin, 'admin')
            ->put(route('schedules.students.link', [$schedule, $student]));

        $response->assertRedirect(route('schedules.students.edit', [$schedule, $student]));
        $this->assertDatabaseHas('schedule_student', [
            'schedule_id' => $schedule->id,
            'student_id' => $student->id,
            'price' => $schedule->price,
            'paid' => 0,
        ]);
    }


    public function testSelectFiltered()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $schedule = factory(Schedule::class)->create();
        $students = factory(Student::class, 2)->create();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('schedules.students.select', $schedule));

        $response->assertSeeText($students[0]->firstname);
        $response->assertSeeText($students[1]->firstname);

        $this->actingAs($admin, 'admin')
            ->put(route('schedules.students.link', [$schedule, $students->first()]));

        $response = $this->actingAs($admin, 'admin')
            ->get(route('schedules.students.select', $schedule));

        $response->assertDontSeeText($students[0]->firstname);
        $response->assertSeeText($students[1]->firstname);
    }


    public function testEdit()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $schedule = factory(Schedule::class)->create();
        $student = factory(Student::class)->create();

        $this->actingAs($admin, 'admin')
            ->put(route('schedules.students.link', [$schedule, $student]));

        $response = $this->actingAs($admin, 'admin')
            ->get(route('schedules.students.edit', [$schedule, $student]));

        $response->assertStatus(200);
        $response->assertViewIs("models.schedule.edit-student");
    }


    public function testUpdateLink()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $schedule = factory(Schedule::class)->create();
        $student = factory(Student::class)->create();

        $response = $this->actingAs($admin, 'admin')
            ->put(route('schedules.students.link', [$schedule, $student]));

        $response->assertRedirect(route('schedules.students.edit', [$schedule, $student]));
        $this->assertDatabaseHas('schedule_student', [
            'schedule_id' => $schedule->id,
            'student_id' => $student->id,
            'price' => $schedule->price,
            'paid' => 0,
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->put(route('schedules.students.link', [$schedule, $student]), [
                'price' => 450,
                'paid' => 350,
            ]);

        $response->assertRedirect(route('schedules.show', $schedule));
        $this->assertDatabaseHas('schedule_student', [
            'schedule_id' => $schedule->id,
            'student_id' => $student->id,
            'price' => 450,
            'paid' => 350,
        ]);
    }
}
