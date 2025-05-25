<?php

namespace Database\Factories;

use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorites>
 */
class FavoritesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'itinerary_id'=>Itinerary::inRandomOrder()->first()?->id ?? Itinerary::factory(),
        ];
    }
}
