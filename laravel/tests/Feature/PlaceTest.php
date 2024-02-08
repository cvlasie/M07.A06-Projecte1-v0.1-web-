<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Place;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_place()
    {   
        $user = User::factory()->create();

        $placeData = [
            'name' => 'Nou Lloc',
            'description' => 'Descripció detallada del lloc',
            'file_id' => 1, 
        ];

        $response = $this->actingAs($user)->postJson('/api/places', $placeData);

        $response->assertStatus(201);
        unset($placeData['file_id']); 
        $this->assertDatabaseHas('places', $placeData);
    }

    public function test_can_retrieve_places()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $place = Place::factory()->create();

        $response = $this->getJson('/api/places');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $place->name]);
    }

    public function test_can_update_place()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $place = Place::factory()->create();
        $updateData = [
            'name' => 'Updated Place Name',
            'description' => 'Descripció actualitzada' 
        ];

        $response = $this->putJson("/api/places/{$place->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('places', $updateData);
    }

    public function test_can_delete_place()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $place = Place::factory()->create();

        $response = $this->deleteJson("/api/places/{$place->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('places', ['id' => $place->id]);
    }

    public function test_can_manage_favorites()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $place = Place::factory()->create();

        $response = $this->postJson("/api/places/{$place->id}/favorites");
        $response->assertStatus(200);
        $this->assertDatabaseHas('favorites', ['place_id' => $place->id, 'user_id' => $user->id]);

        $response = $this->deleteJson("/api/places/{$place->id}/favorites");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', ['place_id' => $place->id, 'user_id' => $user->id]);
    }
}
