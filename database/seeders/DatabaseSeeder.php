<?php

namespace Database\Seeders;

use App\Models\Favorites;
use App\Models\Stage;
use App\Models\User;
use App\Models\City;
use App\Models\Itinerary;
use App\Models\Like;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mario Rossi',
            'email' => 'mario@example.it',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Pietro Bianchi',
            'email' => 'pietro@example.it',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Gino Verdi',
            'email' => 'gino@example.it',
            'password' => Hash::make('12345678'),
        ]);

        City::factory()->count(10)->create();
        Itinerary::factory()->count(100)->create();
        Favorites::factory()->count(10)->create();
        Stage::factory()->count(300)->create();
    }
}
