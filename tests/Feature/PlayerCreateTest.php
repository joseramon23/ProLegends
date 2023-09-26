<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerCreateTest extends TestCase
{
    public function test_create_player() {
        $request = [
            'name' => 'Test',
            'nickname' => 'Test',
            'birthdate' => '2021-01-01',
            'teams_id' => 1,
            'country' => 'Test',
            'rol' => 'mid'
        ];
        $response = $this->post('/api/players', $request);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'player'
        ]);
    }
}
