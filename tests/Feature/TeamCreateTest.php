<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamCreateTest extends TestCase
{
    public function test_create_team() {
        $response = $this->postJson('/api/teams', [
            'name' => 'Test Team',
            'slug' => 'TST',
            'leagues_id' => 1,
            'founded' => 2021,
            'country' => 'Test Country',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'team'
        ]);
    }
}
