<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RenewToken extends TestCase
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

    public function test_renew_token_endpoint_its_available()
    {
        $this->assertTrue(Route::has('auth.renew.token'));
    }

    public function test_users_can_renew_token_using_the_renew_token_endpoint()
    {

        $response = $this->post(route('auth.renew.token'));

        $response->assertJsonFragment([
            'message' => __('api-auth.success'),
        ]);
    }

}
