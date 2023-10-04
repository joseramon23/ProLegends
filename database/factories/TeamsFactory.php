<?php

namespace Database\Factories;

use App\Models\Teams;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamsFactory extends Factory
{
    protected $model = Teams::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->unique()->regexify('[A-Za-z0-9]{3}'),
            'leagues_id' => $this->faker->numberBetween(1, 2),
            'founded' => $this->faker->numberBetween(1900, 2021),
            'country' => $this->faker->country,
            'image' => $this->faker->imageUrl(),
        ];
    }
}