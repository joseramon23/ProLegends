<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeagueReadTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_league_index()
    {
        $response = $this->get('/api/leagues');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'slug',
                'region',
                'founded',
                'image',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function test_league_show() {
        $response = $this->get('/api/leagues/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'slug',
            'region',
            'founded',
            'image',
            'created_at',
            'updated_at',
            'teams'
        ]);
    }
}
