<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class GetUsers extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function test_get_users__endpoint_its_available()
    {
        $this->assertTrue(Route::has('user.get.users'));
    }

    public function test_get_users()
    {

        $users = $this->user = User::factory()->count(3)->create();

        $response = $this->get(route('user.get.users'));

        $response->assertJson([
            'users' => [
                'data' => []
            ]
        ]);
    }

}
