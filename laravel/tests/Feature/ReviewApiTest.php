<?php

namespace Tests\Feature;

use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_create_review(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson("/api/places/{$place->id}/reviews", [
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'place_id' => $place->id,
        ]);
    }

    public function test_user_can_retrieve_reviews(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $review = Review::factory()->create([
            'place_id' => $place->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->getJson("/api/places/{$place->id}/reviews");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $review->id,
        ]);
    }

    public function test_user_can_update_review(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $review = Review::factory()->create([
            'place_id' => $place->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->putJson("/api/places/{$place->id}/reviews/{$review->id}", [
            'rating' => $newRating = $this->faker->numberBetween(1, 5),
            'comment' => $newComment = $this->faker->sentence,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'rating' => $newRating,
            'comment' => $newComment,
        ]);
    }

    public function test_user_can_delete_review(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $review = Review::factory()->create([
            'place_id' => $place->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson("/api/places/{$place->id}/reviews/{$review->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
