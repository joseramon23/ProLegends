<?php

namespace Database\Factories;

use App\Models\Players;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayersFactory extends Factory
{
    protected $model = Players::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'nickname' => $this->faker->userName(),
            'teams_id' => $this->faker->numberBetween(1, 3),
            'birthdate' => $this->faker->date(),
            'country' => $this->faker->country(),
            'image' => $this->faker->imageUrl(),
            'rol' => $this->faker->randomElement(['top', 'jungle', 'mid', 'adc', 'support']),
        ];
    }
}