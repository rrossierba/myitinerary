<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favouriteIds = Favorites::where('user_id', auth()->id())->pluck('itinerary_id');
        $itineraries = Itinerary::whereIn('id', $favouriteIds)->get();
        return view('itinerary.userFavourites')
        ->with('itineraries', $itineraries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Favorites::create([
            'user_id' => auth()->id(),
            'itinerary_id' => $request->itineraryId,
        ]);

        return Redirect::to(route('itinerary.show', ['itinerary'=> $request->itineraryId]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($favourite)
    {   
        // soft delete, to be done with AJAX
        $to_delete = Favorites::find($favourite);
        $to_delete->delete();
        //return 'favourite' removed
        return Redirect::to(route('home'));
    }
}
