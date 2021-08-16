<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_confirm_password_endpoint_its_available()
    {
        $this->assertTrue(Route::has('auth.password.confirm'));
    }

    public function test_password_can_be_confirmed()
    {
        $response = $this->postJson(route('auth.password.confirm'), [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertJsonFragment([
            'message' => __('api-auth.password_confirmed')
        ]);
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {

        $response = $this->actingAs($this->user)->postJson(route('auth.password.confirm'), [
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson([
            'errors' => [
                'password' => []
            ]
        ]);
    }
}
