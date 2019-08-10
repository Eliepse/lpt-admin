<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\ClientUser;
use App\StaffUser;
use App\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function getPasswordBroker(): PasswordBroker
    {
        return Password::broker();
    }


    public function testShowResetForm()
    {
        $response = $this->get(route('password.reset', [
            'token' => 'token1234',
            'email' => 'j.doe@exemple.com',
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('token', 'token1234');
        $response->assertViewHas('email', 'j.doe@exemple.com');
    }


    public function testResetClient()
    {
        $user = factory(ClientUser::class)->create();
        $password = $this->faker->password(8);
        $token = $this->getPasswordBroker()->createToken($user);

        $response = $this
            ->from(route('password.reset', ['token' => $token, 'email' => $user->email,]))
            ->post(route('password.update', [
                'email' => $user->email,
                'token' => $token,
                'password' => $password,
                'password_confirmation' => $password,
            ]));

        $response->assertRedirect(route('home'));
    }


    public function testResetStaffInvalidPassword()
    {
        $user = factory(StaffUser::class)->create();
        $password = $this->faker->password(5, 11);
        $token = $this->getPasswordBroker()->createToken($user);

        $response = $this
            ->from(route('password.reset', ['token' => $token, 'email' => $user->email,]))
            ->post(route('password.update', [
                'email' => $user->email,
                'token' => $token,
                'password' => $password,
                'password_confirmation' => $password,
            ]));

        $response->assertRedirect(route('password.reset', ['email' => $user->email, 'token' => $token,]));
        $response->assertSessionHasErrors('password');
    }


    public function testResetStaff()
    {
        $user = factory(StaffUser::class)->create();
        $password = $this->faker->password(12);
        $token = $this->getPasswordBroker()->createToken($user);

        $response = $this
            ->from(route('password.reset', ['token' => $token, 'email' => $user->email,]))
            ->post(route('password.update', [
                'email' => $user->email,
                'token' => $token,
                'password' => $password,
                'password_confirmation' => $password,
            ]));

        $response->assertRedirect(route('dashboard'));
    }
}
