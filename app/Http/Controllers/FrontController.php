<?php

namespace App\Http\Controllers;

use App\Models\DTO\Feature;

class FrontController extends Controller
{
    public function home(){
        $features = [
            new Feature('Scopri tutti gli itinerari', 'itinerary.index', 'all-itineraries.jpg'),
            new Feature('Cerca itinerario', 'itinerary.search', 'search-itinerary.jpg'),
            new Feature('Crea il tuo itinerario', 'itinerary.create', 'create-itinerary.jpg'),
        ];

        return view('index')
        ->with('features', $features);
    }

    public function itineraryTest(){
        return view('itinerary');
    }
}
