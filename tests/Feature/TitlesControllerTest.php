<?php

namespace Tests\Feature;

use App\Models\Players;
use App\Models\Players_titles;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TitlesControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Test creating a title for a player and a team.
     *
     * @return void
     */
    public function testCreateTitleForPlayerAndTeam()
    {
        $player = Players::factory()->create();
        $team = $player->team;
        $league = $team->league;

        $data = [
            'name' => $this->faker->name,
            'player_id' => $player->id,
            'team_id' => $team->id,
            'league_id' => 1,
            'date' => $this->faker->date('Y-m-d'),
        ];

        $response = $this->postJson('/api/titles', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Title created successfully'
            ]);

        $this->assertDatabaseHas('players_titles', $data);
    }

    /**
     * Test creating a title for a player.
     *
     * @return void
     */
    public function testCreateTitleForPlayer()
    {
        $player = Players::factory()->create();
        $league = $player->team->league;

        $data = [
            'name' => $this->faker->name,
            'player_id' => $player->id,
            'league_id' => $league->id,
            'date' => $this->faker->date('Y-m-d'),
        ];

        $response = $this->postJson('/api/titles', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Title created successfully',
            ]);

        $this->assertDatabaseHas('players_titles', $data);
    }

    /**
     * Test creating a title for all players of a team.
     *
     * @return void
     */
    public function testCreateTitleForTeam()
    {
        $team = Players::factory()->create()->team;
        $league = $team->league;

        $data = [
            'name' => $this->faker->name,
            'team_id' => $team->id,
            'league_id' => $league->id,
            'date' => $this->faker->date('Y-m-d'),
        ];

        $response = $this->postJson('/api/titles', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'The title has been added to all players of the team',
            ]);

        $this->assertDatabaseHas('players_titles', [
            'name' => $data['name'],
            'team_id' => $team->id,
            'league_id' => $league->id,
            'date' => $data['date'],
        ]);
    }

    /**
     * Test updating a title.
     *
     * @return void
     */
    public function testUpdateTitle()
    {
        $title = Players_titles::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'player_id' => $title->player_id,
            'team_id' => $title->team_id,
            'league_id' => $title->league_id,
            'date' => $this->faker->date('Y-m-d'),
        ];

        $response = $this->putJson("/api/titles/{$title->id}", $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('players_titles', $data);
    }

    /**
     * Test showing a title.
     *
     * @return void
     */
    public function testShowTitle()
    {
        $title = Players_titles::factory()->create();

        $response = $this->getJson("/api/titles/{$title->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $title->id,
                'name' => $title->name,
                'player' => [
                    'id' => $title->player->id,
                    'name' => $title->player->name,
                    'nickname' => $title->player->nickname,
                ],
                'team' => [
                    'id' => $title->team->id,
                    'name' => $title->team->name,
                ],
                'league' => $title->league->name,
                'date' => $title->date,
            ]);
    }
}