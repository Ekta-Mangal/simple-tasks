<?php

namespace Tests\Feature;

use App\Models\App;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AppsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test listing apps.
     *
     * This test verifies that it can list apps based on certain conditions.
     */
    public function test_it_can_list_apps(): void
    {
        // Create a new app with specific name
        App::factory(['name' => 'App 10'])->create();

        // Make a GET request with query parameters to list apps
        $result = $this->getJson('/api/apps' . '?name=App 10')
            ->assertStatus(Response::HTTP_OK);

        // Assert the count of meta data and apps in the response
        $result->assertJsonCount(8, 'meta.*');
        $result->assertJsonCount(1, 'data.*');
    }
}
