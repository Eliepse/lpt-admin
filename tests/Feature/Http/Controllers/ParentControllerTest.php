<?php

namespace Tests\Feature\Http\Controllers;

use App\ClientUser;
use App\Family;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ParentController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParentControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testCreate()
    {
        $family = factory(Family::class)->create();

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->get(action([ParentController::class, 'create'], $family));

        $response->assertStatus(200);
        $response->assertViewIs('models.clientUser.create');
    }


    public function testStore()
    {
        $family = factory(Family::class)->create();

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->post(action([ParentController::class, 'store'], $family), $parent = [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'j.doe@exemple.com',
                'wechat_id' => 'jd199845',
                'phone' => '0600000000',
                'address' => null,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(action([FamilyController::class, 'show'], $family));
        $this->assertDatabaseHas('users', array_merge($parent, ['family_id' => $family->id]));
    }


    public function testEdit()
    {
        $parent = factory(ClientUser::class)->create();

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->get(action([ParentController::class, 'edit'], $parent));

        $response->assertStatus(200);
        $response->assertViewIs('models.clientUser.edit');
    }


    public function testUpdate()
    {
        /** @var ClientUser $parent */
        $parent = factory(ClientUser::class)->create($before = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'j.doe@exemple.com',
            'wechat_id' => 'jd199845',
            'phone' => '0600000000',
            'address' => null,
        ]);

        $response = $this->actingAs($this->createAdmin(), 'admin')
            ->put(action([ParentController::class, 'update'], $parent), $after = [
                'email' => 'j.doe@superman.com',
                'wechat_id' => 'jd666888',
            ]);

        $parent->refresh();

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(action([FamilyController::class, 'show'], $parent->family));
        $this->assertNotEquals($parent->email, $before['email']);
        $this->assertEquals($parent->wechat_id, $after['wechat_id']);
    }
}
