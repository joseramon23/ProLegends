<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeagueDeleteTest extends TestCase
{
    public function test_delete_league() {
        $response = $this->delete('/api/leagues/15');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'league' 
        ]);
    }
}
