<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class Logout extends TestCase
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

    public function test_logout_endpoint_its_available()
    {
        $this->assertTrue(Route::has('auth.logout'));
    }

    public function test_users_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->get(route('auth.logout'));

        $response->assertJsonFragment([
            'message' => __('api-auth.logout'),
        ]);
    }

}
