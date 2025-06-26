<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
