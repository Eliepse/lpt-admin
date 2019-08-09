<?php

namespace Tests\Feature\Http\Controllers\Administration;

use App\Sets\UserRolesSet;
use App\StaffUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('staff.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.staff.index');
    }


    public function testIndexSearchToJSON()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);
        $manager = factory(StaffUser::class)->create([
            'email' => 'j.doe@exemple.com',
            'roles' => new UserRolesSet([UserRolesSet::MANAGER,]),
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->getJson(route('staff.index', ['has_role' => UserRolesSet::MANAGER]));

        $response->assertStatus(200);
        $response->assertJson([
            [
                'email' => 'j.doe@exemple.com',
                'roles' => [UserRolesSet::MANAGER],
                'type' => 'staff',
            ],
        ]);
    }


    public function testCreate()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('staff.create'));

        $response->assertStatus(200);
    }


    public function testStore()
    {
        $admin = factory(StaffUser::class)->create(['roles' => new UserRolesSet([UserRolesSet::ADMIN])]);

        $response = $this->actingAs($admin, 'admin')
            ->post(route('staff.store', [
                'firstname' => 'john',
                'lastname' => 'doe',
                'email' => 'j.doe@exemple.com',
                'wechat_id' => 'johndoe123',
                'phone' => '0612345678',
                'roles' => [UserRolesSet::MANAGER, UserRolesSet::ADMIN],
                'address' => '651 Some street, City 98886 Country',
            ]));

        $response->assertRedirect(route('staff.index'));
        $this->assertDatabaseHas('users', [
            'firstname' => 'john',
            'lastname' => 'doe',
            'type' => 'staff',
            'roles' => new UserRolesSet([UserRolesSet::MANAGER, UserRolesSet::ADMIN]),
        ]);
    }
}
