<?php

namespace App\Http\Controllers;

use App\Models\DTO\Feature;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function home(){
        $features = [
            new Feature('Scopri tutti gli itinerari', 'itinerary.index', 'all-itineraries.jpg'),
            new Feature('Cerca itinerario', 'itinerary.search', 'search-itinerary.jpg'),
            new Feature('Crea il tuo itinerario', 'itinerary.create', 'create-itinerary.jpg'),
        ];
        
        $index = true;

        return view('index')
        ->with('features', $features)
        ->with('index', $index);
    }

    public function itineraryTest(){
        return view('itinerary');
    }
}
