<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class Update extends TestCase
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

    public function test_update_endpoint_its_available()
    {
        $this->assertTrue(Route::has('auth.update.user'));
    }

    public function test_users_can_update_using_update_endpoint()
    {
        $response = $this->put(route('auth.update.user'), [
            'name' => 'Test User'
        ]);

        $response->assertJsonFragment([
            'message' => __('api-auth.user_update'),
        ]);
    }
}
