<?php

declare(strict_types=1);

namespace Tests\Feature\Media;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

final class UploadMediaTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_upload_media(): void
    {
        $user = User::factory()->create();
        $apartment = Apartment::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);

        $response = $this->postJson(route('account.apartments.media.store', [
            'apartment' => $apartment->id,
        ]), [
            'files' => [
                UploadedFile::fake()->image('apartment_1.jpg'),
                UploadedFile::fake()->image('apartment_2.jpg'),
            ],
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseCount('media', 3);
    }

    public function test_can_not_update_media_as_not_owner()
    {
        $user = User::factory()->create();
        $apartment = Apartment::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('account.apartments.media.store', [
            'apartment' => $apartment->id,
        ]));
        $response->assertStatus(403);
    }

    public function test_cannot_upload_unauthorized()
    {
        $apartment = Apartment::factory()->create();
        $response = $this->postJson(route('account.apartments.media.store', [
            'apartment' => $apartment->id,
        ]));
        $response->assertStatus(401);
    }
}
