<?php

namespace Database\Seeders;

use App\Models\Itinerary;
use Illuminate\Database\Seeder;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Itinerary::factory()->count(1000)->create();
    }
}
