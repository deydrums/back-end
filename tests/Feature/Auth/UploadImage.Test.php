<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class UploadImage extends TestCase
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

    public function test_upload_image_endpoint_its_available()
    {
        $this->assertTrue(Route::has('auth.upload.image'));
    }

    public function test_users_can_upload_image()
    {
        Storage::fake('users');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post(route('auth.upload.image'), [
            'file' => $file,
        ]);

        $response->assertJsonFragment([
            'message' => __('api-auth.image_upload'),
        ]);
    }


    public function test_users_cant_upload_image_if_file_isnt_type_image()
    {
        Storage::fake('users');

        $file = UploadedFile::fake()->image('doc.pdf');

        $response = $this->postJson(route('auth.upload.image'), [
            'file' => $file,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson([
            'errors' => [
                'file' => []
            ]
        ]);

    }

}