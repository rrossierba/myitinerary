<?php

namespace App\Http\Controllers;

use App\Enum\Visibility;
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
        $itinerary = Itinerary::find($request->itineraryId);
        if ($itinerary->visibility == Visibility::PUBLIC) {
            Favorites::create([
                'user_id' => auth()->id(),
                'itinerary_id' => $itinerary->id,
            ]);

            return Redirect::to(route('itinerary.show', ['itinerary' => $request->itineraryId]));
        } else {
            return 'errore, proibito';
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($favourite)
    {
        $to_delete = Favorites::find($favourite);
        if ($to_delete->user_id == auth()->id()) {
            $to_delete->delete();
            return Redirect::to(route('home'));
        }
    }
}
