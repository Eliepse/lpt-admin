<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Http\Controllers\Admin\StaffUserPasswordController;
use App\Sets\UserRolesSet;
use App\StaffUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class StaffUserPasswordControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testForm()
    {
        $staff = factory(StaffUser::class)->create();

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->get(action([StaffUserPasswordController::class, 'form'], $staff));

        $response->assertStatus(200);
        $response->assertViewIs('admin.staff.password');
    }


    public function testUpdate()
    {
        /** @var StaffUser $staff */
        $staff = factory(StaffUser::class)->create(['password' => $oldPassword = Hash::make('123456789')]);

        $response = $this->actingAs($staff, 'admin')
            ->put(
                action([StaffUserPasswordController::class, 'update'], $staff),
                ['password' => 'abcdefghijkl']
            );

        $staff->refresh();

        $response->assertRedirect(route('staff.index'));
        $this->assertNotEquals($oldPassword, $staff->password);
    }


    public function testUpdateNotAllowed()
    {
        $a = factory(StaffUser::class)->create(['roles' => new UserRolesSet(UserRolesSet::TEACHER)]);
        $b = factory(StaffUser::class)->create(['roles' => new UserRolesSet(UserRolesSet::TEACHER)]);

        $response = $this->actingAs($a, 'admin')
            ->put(
                action([StaffUserPasswordController::class, 'update'], $b),
                ['password' => Str::random(16)]
            );

        $response->assertStatus(403);
    }
}
