<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamUpdateTest extends TestCase
{
    public function test_update_team() {
        $response = $this->put('/api/teams/4', [
            'name' => 'Team Test Updated',
            'slug' => 'TTU',
            'leagues_id' => 1,
            'founded' => '2022',
            'country' => 'TestUpdated',
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'team'
        ]);
    }
}
