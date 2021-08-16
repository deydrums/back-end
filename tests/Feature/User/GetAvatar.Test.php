<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;


class GetAvatar extends TestCase
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


    public function test_get_avatar_endpoint_its_available()
    {
        $this->assertTrue(Route::has('user.get.avatar'));
    }

    public function test_get_avatar()
    {
        Storage::fake('users');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->post(route('auth.upload.image'), [
            'file' => $file,
        ]);

        $verificationUrl = URL::route(
            'user.get.avatar',
            ['filename' => time().'avatar', 'ext' => 'jpg']
        );

        var_dump($verificationUrl);

        $response = $this->get($verificationUrl);

        $response->assertStatus(Response::HTTP_OK);
    }
}
