<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerUpdateTest extends TestCase
{
    public function test_update_player() {
        $response = $this->put('/api/players/17', [
            'name' => 'TestUpdate',
            'nickname' => 'TestUpdate',
            'birthdate' => '2021-01-01',
            'teams_id' => 2,
            'country' => 'TestUpdated',
            'rol' => 'jungle'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'player'
        ]);
    }
}
