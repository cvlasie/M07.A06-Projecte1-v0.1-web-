<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\File;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post()
    {   
        $user = User::factory()->create();
    
        $file = File::factory()->create();
    
        $postData = [
            'body' => 'New Post',
            'file_id' => $file->id,
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'author_id' => $user->id,
        ];
    
        $response = $this->actingAs($user)->postJson('/api/posts', $postData);
    
        $response->assertStatus(201);
        unset($postData['file_id']); 
        $this->assertDatabaseHas('posts', $postData);
    }

    public function test_can_retrieve_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $post = Post::factory()->create();
    
        $response = $this->getJson('/api/posts');
    
        $response->assertStatus(200);
        $response->assertJsonFragment(['body' => $post->body]);
    }

    public function test_can_update_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $post = Post::factory()->create();
        $updateData = [
            'body' => 'Updated Post Body',
            'file_id' => $post->file_id,
            'latitude' => $post->latitude,
            'longitude' => $post->longitude,
            'author_id' => $post->author_id,
        ];
    
        $response = $this->putJson("/api/posts/{$post->id}", $updateData);
    
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', $updateData);
    }

    public function test_can_delete_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_can_manage_likes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create();

        $response = $this->postJson("/api/posts/{$post->id}/likes");
        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', ['post_id' => $post->id, 'user_id' => $user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}/likes");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('likes', ['post_id' => $post->id, 'user_id' => $user->id]);
    }
}