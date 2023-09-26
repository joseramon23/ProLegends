<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamReadTest extends TestCase
{
    public function test_read_teams() {
        $response = $this->get('/api/teams');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'slug',
                'leagues_id',
                'founded',
                'country',
                'image',
                'created_at',
                'updated_at',
                'players',
                'league'
            ]
        ]);
    }

    public function test_read_team() {
        $response = $this->get('/api/teams/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'slug',
            'leagues_id',
            'founded',
            'country',
            'image',
            'created_at',
            'updated_at',
            'players',
            'league'
        ]);
    }
}
