<?php

namespace Database\Factories;

use App\Models\Players;
use App\Models\Players_titles;
use App\Models\Teams;
use App\Models\Leagues;
use Illuminate\Database\Eloquent\Factories\Factory;

class Players_titlesFactory extends Factory
{
    protected $model = Players_titles::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'player_id' => Players::factory(),
            'team_id' => Teams::factory(),
            'league_id' => Leagues::factory(),
            'date' => $this->faker->date(),
        ];
    }
}
