<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = City::pluck('state')->unique();
        return view('city.cities')
        ->with('states', $states);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('city.editCity');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inputName'=>['required', 'string', 'max:255'],
            'inputRegion'=>['required', 'string', 'max:255'],
            'inputState'=>['required', 'string', 'max:255'],
        ]);

        City::create([
            'name'=>$request->input('inputName'),
            'region'=>$request->input('inputRegion'),
            'state'=>$request->input('inputState')
        ]);

        return Redirect::to(route('city.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view('city.editCity')->with('city', $city);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'inputName'=>['required', 'string', 'max:255'],
            'inputRegion'=>['required', 'string', 'max:255'],
            'inputState'=>['required', 'string', 'max:255'],
        ]);

        $city->update([
            'name'=>$request->input('inputName'),
            'region'=>$request->input('inputRegion'),
            'state'=>$request->input('inputState')
        ]);

        return Redirect::to(route('city.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return Redirect::to(route('city.index'));
    }

    public function destroyConfirm(City $city){
        return view('city.deleteCity')->with('city', $city);
    }

    //AJAX
    public function search(Request $request)
    {
        $query = $request->get('q');

        $cities = City::where('name', 'like', $query . '%')
            ->limit(10)
            ->get(['name', 'region', 'state']);

        return response()->json($cities);
    }

    public function searchRegion(Request $request){
        $state = $request->get('state');
        $regions = City::where('state', $state)->orderBy('region', 'asc')->pluck('region')->unique()->values();
        return response()->json($regions);
    }

    public function searchCitiesByRegion(Request $request){
        $state = $request->get('state');
        $region = $request->get('region');

        $cities = City::where([
            'state'=>$state,
            'region'=>$region
        ])->get(['name', 'region', 'state', 'id']);
        
        return response()->json(data: $cities);
    }

    public function exist(Request $request){
        $cityRegex = '/^([\p{L}\s]+) \(([\p{L}\s]+), ([\p{L}\s]+)\)$/u';

        $request->validate([
            'cityString'=>['required', 'regex:'.$cityRegex]
        ]);

        if($request->get('cityString')!== null){
            if (preg_match($cityRegex, $request->get('cityString'), $matches)) {
                $name = trim($matches[1]);  
                $region = trim($matches[2]);    
                $state = trim($matches[3]);      
            }
        }else{
            $state = $request->get('state');
            $region = $request->get('region');
            $name = $request->get('name');
        }

        return response()->json(['exist'=>City::where([
            'state'=>$state,
            'region'=>$region,
            'name'=>$name
        ])->exists()]);
    }
}
