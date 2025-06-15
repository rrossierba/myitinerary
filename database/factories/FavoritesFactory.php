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
        $user_id = User::inRandomOrder()->first()?->id ?? User::factory();
        return [
            'user_id' => $user_id,
            'itinerary_id'=>Itinerary::where('visibility', 'public')
            ->where('user_id', '!=', $user_id)
            ->inRandomOrder()->first()?->id ?? Itinerary::factory(),
        ];
    }
}
