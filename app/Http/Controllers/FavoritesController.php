<?php

namespace App\Http\Controllers;

use App\Enum\Visibility;
use App\Models\Favorites;
use App\Models\Itinerary;
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
        return view('itinerary.favourites')
            ->with('itineraries', $itineraries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itinerary_id'=>['required']
        ]);

        $itinerary = Itinerary::find($request->get('itinerary_id'));

        if($itinerary->visibility == Visibility::PUBLIC){
            Favorites::create([
                'user_id' => auth()->id(),
                'itinerary_id' => $itinerary->id,
            ]);
            $result = ['created'=>true];
        }
        else
            $result = ['created'=>false];
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'itinerary_id'=>['required']
        ]);

        $to_delete = Favorites::where([
            'itinerary_id'=>$request->get('itinerary_id'),
            'user_id'=>auth()->id()
        ])->get()->first();

        if($to_delete!==null){
            $to_delete->delete();
            $result = ['deleted'=>true];
        }else
            $result = ['deleted'=>false];

        return response()->json($result);
    }
}
