<?php

namespace Tests\Feature\Http\Controllers;

use App\Family;
use App\Schedule;
use App\Sets\UserRolesSet;
use App\StaffUser;
use App\Student;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $student = factory(Student::class)->create();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('students.index'));

        $response->assertStatus(200);
        $response->assertViewIs('models.student.index');
    }


    public function testCreate()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $family = factory(Family::class)->create();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('students.create', $family));

        $response->assertStatus(200);
        $response->assertViewIs('models.student.create');
    }


    public function testStore()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $family = factory(Family::class)->create();
        $attrs = [
            'firstname' => 'tom',
            'lastname' => 'zhao',
            'birthday' => Carbon::yesterday(),
        ];

        $response = $this->actingAs($admin, 'admin')
            ->post(route('students.store', $family), $attrs);

        $response->assertRedirect(route('families.show', $family));
        $this->assertDatabaseHas('students', $attrs);
    }


    public function testEdit()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        /** @var Family $family */
        $family = factory(Family::class)->create();
        $student = $family->students()->create($attrs = [
            'firstname' => 'tom',
            'lastname' => 'zhao',
            'birthday' => Carbon::yesterday(),
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('students.edit', $student));

        $response->assertStatus(200);
        $response->assertViewIs('models.student.edit');
    }


    public function testUpdate()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        /** @var Family $family */
        $family = factory(Family::class)->create();
        $student = $family->students()->create($attrs = [
            'firstname' => 'tom',
            'lastname' => 'zhao',
            'birthday' => Carbon::yesterday(),
        ]);

        $attrs['firstname'] = 'tim';

        $response = $this->actingAs($admin, 'admin')
            ->put(route('students.update', $student), $attrs);

        $response->assertRedirect(route('families.show', $family));
        $this->assertDatabaseHas('students', $attrs);
    }
}
