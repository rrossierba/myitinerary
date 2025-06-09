<?php

namespace Database\Factories;

use App\Models\Itinerary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stage>
 */
class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location'=>$this->faker->streetName(),
            'description'=>$this->faker->realText(),
            'duration'=>$this->faker->randomDigit(),
            'cost'=>$this->faker->randomFloat(2, 10, 500),
            'itinerary_id'=>Itinerary::inRandomOrder()->first()?->id ?? Itinerary::factory(),
        ];
    }
}
