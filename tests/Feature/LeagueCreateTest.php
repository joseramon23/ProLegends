<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeagueCreateTest extends TestCase
{
    public function test_create_league() {
        $response = $this->post('/api/leagues', [
            'name' => 'League Test',
            'slug' => 'LT',
            'region' => 'Test',
            'founded' => '2021',
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
