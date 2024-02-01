<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class FileTest extends TestCase
{
    public function test_file_list()
    {
        $response = $this->getJson("/api/files");
        $this->_test_ok($response);
    }

    public function test_file_create(): object
    {
        $name = "avatar.png";
        $size = 500; 
        $upload = UploadedFile::fake()->image($name)->size($size);
        $response = $this->postJson("/api/files", [
            "upload" => $upload,
        ]);
        $this->_test_ok($response, 201);
        $response->assertValid(["upload"]);
        $response->assertJsonPath("data.filesize", $size * 1024);
        $response->assertJsonPath('data.filepath', fn($filepath) => str_contains($filepath, 'uploads'));

        $json = $response->json();
        return (object) $json['data'];
    }


    public function test_file_create_error()
    {
        $name = "avatar.png";
        $size = 5000; 
        $upload = UploadedFile::fake()->image($name)->size($size);
        $response = $this->postJson("/api/files", [
            "upload" => $upload,
        ]);
        $this->_test_error($response);
    }

    /**
     * @depends test_file_create
     */
    public function test_file_read(object $file)
    {
        $response = $this->getJson("/api/files/{$file->id}");
        $this->_test_ok($response);
        $response->assertJsonPath("data.filepath", fn ($filepath) => !empty($filepath));
    }

    public function test_file_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/files/{$id}");
        $this->_test_notfound($response);
    }

    /**
     * @depends test_file_create
     */
    public function test_file_update(object $file)
    {
        $name = "photo.jpg";
        $size = 1000; 
        $upload = UploadedFile::fake()->image($name)->size($size);
        $response = $this->putJson("/api/files/{$file->id}", [
            "upload" => $upload,
        ]);
        $this->_test_ok($response);
        $response->assertValid(["upload"]);
        $response->assertJsonPath("data.filesize", $size * 1024);
        $response->assertJsonPath('data.filepath', fn($filepath) => str_contains($filepath, 'uploads'));
    }


    /**
     * @depends test_file_create
     */
    public function test_file_update_error(object $file)
    {
        $name = "photo.jpg";
        $size = 3000; 
        $upload = UploadedFile::fake()->image($name)->size($size);
        $response = $this->putJson("/api/files/{$file->id}", [
            "upload" => $upload,
        ]);
        $this->_test_error($response);
    }

    public function test_file_update_notfound()
    {
        $id = "not_exists";
        $response = $this->putJson("/api/files/{$id}");
        $this->_test_notfound($response);
    }


    /**
     * @depends test_file_create
     */
    public function test_file_delete(object $file)
    {
        $response = $this->deleteJson("/api/files/{$file->id}");
        $response->assertStatus(200);
    }


    public function test_file_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/files/{$id}");
        $this->_test_notfound($response);
    }

    protected function _test_ok($response, $status = 200)
    {
        $response->assertStatus($status);
        $response->assertJson([
            "success" => true,
        ]);
        $response->assertJsonPath("data", fn ($data) => is_array($data));
    }

    protected function _test_error($response)
    {
        $response->assertStatus(422);
        $response->assertInvalid(["upload"]);
        $response->assertJson([
            "message" => true, 
            "errors" => true, 
        ]);
        $response->assertJsonPath("message", fn ($message) => !empty($message) && is_string($message));
        $response->assertJsonPath("errors", fn ($errors) => is_array($errors));
    }

    protected function _test_notfound($response)
    {
        $response->assertStatus(404);
        $response->assertJson([
            "success" => false,
            "message" => true, 
        ]);
        $response->assertJsonPath("message", fn ($message) => !empty($message) && is_string($message));
    }
}
