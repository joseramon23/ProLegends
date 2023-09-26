<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerReadTest extends TestCase
{
    public function test_read_index_players() {
        $response = $this->get('/api/players');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'nickname',
                'birthdate',
                'teams_id',
                'country',
                'image',
                'rol',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_read_player() {
        $response = $this->get('/api/players/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'nickname',
            'birthdate',
            'teams_id',
            'country',
            'image',
            'rol',
            'created_at',
            'updated_at'
        ]);
    }
}
