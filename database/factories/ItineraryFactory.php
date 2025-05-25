<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itinerary>
 */
class ItineraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $city_id = City::inRandomOrder()->first()?->id ?? City::factory();
        return [
            'city_id' => $city_id,
            'title' => sprintf('%s in %s', $this->faker->sentence(3), City::find(($city_id))->name),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'visibility' => $this->faker->randomElement(['public', 'private']),
            'price' => $this->faker->randomFloat(2, 10, 500)
        ];
    }
}
