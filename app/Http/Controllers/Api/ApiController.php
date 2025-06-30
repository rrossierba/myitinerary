<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\ItineraryResource;
use App\Models\City;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getItineraries(Request $request)
    {
        return ItineraryResource::collection(Itinerary::where('visibility', 'public')->get());
    }

    public function getItinerariesByTitle(Request $request, string $title)
    {
        if (Itinerary::where('title', 'like', "%{$title}%")->exists())
            return ItineraryResource::collection(Itinerary::where('visibility', 'public')->where('title', 'like', "%{$title}%")->get());
        else
            return response()->json(['data' => ['error' => 'itinerary not found']]);
    }

    public function getCities(Request $request)
    {
        return CityResource::collection(City::all());
    }

    public function getCitiesByState(Request $request, string $state)
    {
        if (City::where('state', $state)->exists())
            return CityResource::collection(City::where('state', $state)->get());
        else
            return response()->json(['data' => ['error' => 'city not found']]);
    }

    public function getCitiesByStateRegion(Request $request, string $state, string $region)
    {
        if (City::where('state', $state)->where('region', $region)->exists())
            return CityResource::collection(City::where('state', $state)->where('region', $region)->get());
        else
            return response()->json(['data' => ['error' => 'city not found']]);
    }

}
