<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function test_file_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/files');
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_file_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $fileData = [
            'nom' => 'Test File',
            'upload' => UploadedFile::fake()->image('file.jpg')
        ];

        $response = $this->postJson('/api/files', $fileData);
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    }

    public function test_file_read()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = File::factory()->create();

        $response = $this->get("/api/files/{$file->id}");
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_file_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = File::factory()->create();
        $updateData = ['nom' => 'Updated Name'];

        $response = $this->putJson("/api/files/{$file->id}", $updateData);
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_file_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = File::factory()->create();

        $response = $this->delete("/api/files/{$file->id}");
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_file_create_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = ['nom' => ''];

        $response = $this->postJson('/api/files', $invalidData);
        $response->assertStatus(422)
                 ->assertJsonStructure(['message', 'errors']);
    }

    public function test_file_update_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = File::factory()->create();
        $invalidUpdateData = ['nom' => ''];

        $response = $this->putJson("/api/files/{$file->id}", $invalidUpdateData);
        $response->assertStatus(422)
                 ->assertJsonStructure(['message', 'errors']);
    }

    public function test_file_read_notfound()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/files/9999'); 
        $response->assertStatus(404)
                 ->assertJson(['success' => false]);
    }

    public function test_file_update_notfound()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $updateData = ['nom' => 'Any Name'];

        $response = $this->putJson('/api/files/9999', $updateData); 
        $response->assertStatus(404)
                 ->assertJson(['success' => false]);
    }

    public function test_file_delete_notfound()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete('/api/files/9999'); 
        $response->assertStatus(404)
                 ->assertJson(['success' => false]);
    }
}
