<?php

namespace Database\Seeders;

use App\Models\Favorites;
use App\Models\Stage;
use App\Models\User;
use App\Models\City;
use App\Models\Itinerary;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use File;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedUsers();
        $this->seedItalianCities();
        Itinerary::factory()->count(1000)->create();
        // Favorites::factory()->count(100)->create();
        Stage::factory()->count(3000)->create();
    }

    private function seedUsers(){
        $password = '12345678';
        $users = ['Admin', 'Mario Rossi', 'Gino Verdi', 'Pietro Bianchi', 'Giovanni Storti', 'Giacomo Poretti', 'Aldo Baglio'];

        foreach($users as $user){
            User::factory()->create([
                'name' => $user,
                'email' => strtolower(explode(' ', $user)[0].'@example.it'),
                'password' => Hash::make($password),
                'role' => $user === 'Admin'?'admin':'registered_user'
            ]);
        }
    }

    private function seedItalianCities(){
        $json = Storage::get('cities_population/comuni.json');
        $data = json_decode($json, true);

        foreach ($data as $city){
            City::create([
                'name'=>$city['nome'],
                'region'=> $city['regione']['nome'],
                'state'=>'Italia'
            ]);
        }
    }
}
