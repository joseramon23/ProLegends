<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeagueUpdateTest extends TestCase
{
    public function test_update_league() {
        $response = $this->put('/api/leagues/14', [
            'name' => 'League Test Updated',
            'slug' => 'LTU',
            'region' => 'TestUpdated',
            'founded' => '2022',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'league' => [
                'id',
                'name',
                'slug',
                'region',
                'founded',
                'image',
                'created_at',
                'updated_at'
            ]
        ]);
    }
}
