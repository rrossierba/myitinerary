<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ItineraryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('itinerary.itineraries')
        ->with('itineraries', $itineraries);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('itinerary.editItinerary')
        ->with('cities', City::orderBy('name','desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inputTitle' => ['required', 'string', 'max:255'],
            'citySelector' => ['required', 'string', 'max:255'],
            'visibilitaRadio' => ['required', 'string', 'in:public,private'],
        ]);

        $itinerary = Itinerary::create([
            'title' => $request->input('inputTitle'),
            'city_id' => $this->findCity($request->input('citySelector'))->id,
            'visibility' => $request->input('visibilitaRadio'),
            'user_id' => auth()->id(),
        ]);
        
        return Redirect::to(route('stage.new', ['itinerary'=>$itinerary]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $itinerary)
    {
        $this->authorize('view', $itinerary);
        return view('itinerary.itineraryDetail')->with('itinerary', $itinerary);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);
        $cities = City::orderBy('name','desc')->get();
        return view('itinerary.editItinerary')
        ->with('itinerary', $itinerary)
        ->with('cities', $cities);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);

        $request->validate([
            'inputTitle' => ['required', 'string', 'max:255'],
            'citySelector' => ['required', 'string', 'max:255'],
            'visibilitaRadio' => ['required', 'string', 'in:public,private'],
        ]);

        $itinerary->update([
            'title' => $request->input('inputTitle'),
            'city_id' => $this->findCity($request->input('citySelector'))->id,
            'visibility' => $request->input('visibilitaRadio'),
        ]);

        return Redirect::to(route('itinerary.show', ['itinerary'=>$itinerary]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);
        $itinerary->delete();
        return Redirect::to(route('itinerary.index'));
    }

    public function confirmDestroy(Itinerary $itinerary){
        $this->authorize('isOwner', $itinerary);
        return view('itinerary.confirmDelete')->with('itinerary', $itinerary);
    }

    private function findCity($city_string){
        if (preg_match('/^([\p{L}\s]+) \(([\p{L}\s]+), ([\p{L}\s]+)\)$/u', $city_string, $matches)) {
            $cityName = trim($matches[1]);  
            $cityRegion = trim($matches[2]);    
            $cityState = trim($matches[3]);      
        } else {
            $cityName = $cityRegion = $cityState = null;
        };

        $city = City::where([
            'name'=> $cityName,
            'region'=>$cityRegion,
            'state'=>$cityState
        ])->first();

        return $city;
    }
}
