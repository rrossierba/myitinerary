<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $itineraries = Itinerary::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('stage.editStage')
        ->with('itineraries', $itineraries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Stage::create([
            'location'=>$request->input('inputLocation'),
            'description'=>$request->input('textDescription'),
            'duration'=>$request->input('inputDuration'),
            'cost'=>$request->input('inputPrice'),
            'photo'=>$request->input(''),
            'itinerary_id'=>$request->input('itinerarySelect'),
        ]);

        return($request->submit);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stage $stage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stage $stage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stage $stage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage)
    {
        //
    }
}
