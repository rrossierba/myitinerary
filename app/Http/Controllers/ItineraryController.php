<?php

namespace App\Http\Controllers;

use App\Enum\SearchGroups;
use App\Models\City;
use App\Models\DTO\Filter;
use App\Models\Itinerary;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::where('visibility', 'public')->orderBy('created_at', 'desc')->get();

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
        Itinerary::create([
            'title' => $request->input('inputTitle'),
            'city_id' => $request->input('citySelector'),
            'visibility' => $request->input('visibilitaRadio'),
            'price' => $request->input('inputPrice'),
            'user_id' => auth()->id(),
        ]);
        
        return Redirect::to(route('stage.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $itinerary)
    {
        return view('itinerary.itineraryDetail')->with('itinerary', $itinerary);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itinerary $itinerary)
    {
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
        $itinerary->title = $request->inputTitle;
        $itinerary->city_id = City::find($request->citySelector)->id;
        $itinerary->visibility = $request->visibilitaRadio;
        $itinerary->price = $request->inputPrice;
        $itinerary->save();

        return Redirect::to(route('itinerary.show', ['itinerary'=>$itinerary]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        //
    }

    public function search()
    {
        $filters = [
            new Filter('Titolo', 'title'),
            new Filter('Città', 'city'),
            // new Filter('Categoria', 'category'),
        ];
        if(auth()->user() == null){
            $history = [];
        }
        else{
            $history = Research::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->limit(5)->get();
        }

        return view('search.searchPage')
            ->with('filters', $filters)
            ->with('history', $history);
    }

    public function search_results(Request $request)
    {
        $query_string = $request->input('query');
        $group = $request->input('filter');

        if (isset($query_string) === false && isset($group) == false)
            return '404';
        if ($query_string == '') {
            $results = Itinerary::where('visibility', 'public')->orderBy('created_at', 'desc')->get();
            return view('search.searchResults')
                ->with('itineraries', $results);
        } else {
            $research = new Research;
            $research->query_string = $query_string;
            $research->group = $group;
            
            if(auth()->check()) {
                $research->user_id = auth()->id();
                $research->save();
            }
            
            $query = Itinerary::query();

            if ($group === 'title') {
                $query->where('title', 'like', '%' . $query_string . '%');
            } elseif ($group === 'city') {
                $query->whereHas('city', function ($q) use ($query_string) {
                    $q->where('name', 'like', '%' . $query_string . '%');
                });
            }

            $results = $query->get();
            return view('search.searchResults')
                ->with('itineraries', $results)
                ->with('research', $research);
        }
    }

    public function user_itineraries(Request $request){
        $user_id = auth()->user()->id;
        $itineraries = Itinerary::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('itinerary.userItineraries')
        ->with('itineraries', $itineraries);
    }
}
