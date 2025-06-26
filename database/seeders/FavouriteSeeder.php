<?php

namespace Database\Seeders;

use App\Models\Favorites;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'registered_user')->get();
        $itineraries = Itinerary::where('visibility', 'public')->get();
        
        foreach($users as $user){
            foreach ($itineraries as $itinerary) {
                $i = rand(1,5);
                if($i===1){
                    Favorites::factory()->create([
                        'user_id'=>$user->id,
                        'itinerary_id'=>$itinerary->id
                    ]);
                }
            }
        }
    }
}
