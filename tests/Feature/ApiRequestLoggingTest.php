<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ApiRequest;

class ApiRequestLoggingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_logs_api_requests_for_authenticated_users()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
             ->getJson('/api/v1/profile/' . $user->username);

        $this->assertDatabaseCount('api_requests', 1);
        $this->assertDatabaseHas('api_requests', [
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_logs_api_requests_for_unauthenticated_users()
    {
        $this->getJson('/api/v1/profile/someuser');

        $this->assertDatabaseCount('api_requests', 1);
        $this->assertDatabaseHas('api_requests', [
            'user_id' => null,
        ]);
    }

    /** @test */
    public function it_logs_api_requests_to_non_existent_routes()
    {
        $this->getJson('/api/v1/non-existent-route');

        $this->assertDatabaseCount('api_requests', 1);
        $this->assertDatabaseHas('api_requests', [
            'user_id' => null,
        ]);
    }
}
