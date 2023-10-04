<?php

namespace Tests\Feature;

use App\Models\Players;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Test the index method of the PlayerController.
     *
     * @return void
     */
    public function testIndex()
    {
        $players = Players::factory()->count(3)->create();

        $response = $this->get('/api/players');

        $response->assertStatus(200)
            ->assertJson($players->toArray());
    }

    /**
     * Test the store method of the PlayerController.
     *
     * @return void
     */
    public function testStore()
    {
        Storage::fake('public');

        $data = [
            'name' => $this->faker->name,
            'nickname' => $this->faker->userName,
            'birthdate' => $this->faker->date,
            'teams_id' => 1,
            'country' => $this->faker->country,
            'image' => UploadedFile::fake()->image('player.jpg'),
            'rol' => 'support'
        ];

        $response = $this->post('/api/players', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'The player has been added'
            ]);

        $this->assertFileExists(storage_path('app/public/images/players/' . $data['nickname'] . '.jpg'));

    }

    /**
     * Test the show method of the PlayerController.
     *
     * @return void
     */
    public function testShow()
    {
        $player = Players::factory()->create();

        $response = $this->get('/api/players/' . $player->id);

        $response->assertStatus(200)
            ->assertJson($player->toArray());
    }

    /**
     * Test the update method of the PlayerController.
     *
     * @return void
     */
    public function testUpdate()
    {
        Storage::fake('public');

        $player = Players::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'nickname' => $this->faker->userName,
            'teams_id' => 2,
            'country' => $this->faker->country,
            'image' => UploadedFile::fake()->image('player.jpg'),
            'rol' => 'carry'
        ];

        $response = $this->put('/api/players/' . $player->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Player updated successfully'
            ]);

        $this->assertFileExists(storage_path('app/public/images/players/' . $data['nickname'] . '.jpg'));

    }

    /**
     * Test the destroy method of the PlayerController.
     *
     * @return void
     */
    public function testDestroy()
    {
        $player = Players::factory()->create();

        $response = $this->delete('/api/players/' . $player->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Player has been deleted'
            ]);

    }
}