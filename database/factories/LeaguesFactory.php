<?php

namespace Database\Factories;

use App\Models\Leagues;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaguesFactory extends Factory
{
    protected $model = Leagues::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->unique()->regexify('[A-Za-z0-9]{3}'),
            'region' => $this->faker->country,
            'founded' => $this->faker->numberBetween(1900, 2021),
            'image' => $this->faker->imageUrl(),
        ];
    }
}