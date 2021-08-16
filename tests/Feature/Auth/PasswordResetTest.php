<?php

namespace Tests\Feature\Auth;

use App\Notifications\user\auth\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $sanctum = 'Laravel\Sanctum\Sanctum';
        if (class_exists($sanctum)) {
            \Laravel\Sanctum\Sanctum::actingAs($this->user);
        }
    }

    use RefreshDatabase;

    public function test_reset_password_endpoint_its_available()
    {
        $this->assertTrue(Route::has('auth.password.email'));
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $this->post(route('auth.password.email'), ['email' => $this->user->email]);

        Notification::assertSentTo($this->user, ResetPasswordNotification::class);
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $this->post(route('auth.password.email'), ['email' => $this->user->email]);

        Notification::assertSentTo($this->user, ResetPasswordNotification::class, function ($notification) {
            $response = $this->post(route('auth.password.update'), [
                'token' => $notification->token,
                'email' => $this->user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            $response->assertJsonFragment([
                'message' => __('api-auth.password_updated'),
            ]);

            return true;
        });
    }
}
