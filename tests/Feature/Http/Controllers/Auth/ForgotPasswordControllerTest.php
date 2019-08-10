<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testShowLinkRequestForm()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }


    public function testSendResetLinkEmail()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->from(route('password.request'))
            ->post(route('password.email'), ['email' => $user->email]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status');
    }
}
