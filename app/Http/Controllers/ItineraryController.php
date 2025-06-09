<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DTO\Filter;
use App\Models\Itinerary;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ItineraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy', 'user_itineraries', 'confirmDestroy']);
    }

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
        $itinerary = Itinerary::create([
            'title' => $request->input('inputTitle'),
            'city_id' => $request->input('citySelector'),
            'visibility' => $request->input('visibilitaRadio'),
            'user_id' => auth()->id(),
        ]);
        
        return Redirect::to(route('stage.create', ['itinerary'=>$itinerary]));
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
        $itinerary->title = $request->inputTitle;
        $itinerary->city_id = City::find($request->citySelector)->id;
        $itinerary->visibility = $request->visibilitaRadio;;
        $itinerary->save();

        return Redirect::to(route('itinerary.show', ['itinerary'=>$itinerary]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);
        $itinerary->delete();
        return Redirect::to(route('itinerary.user.created'));
    }

    public function confirmDestroy(Itinerary $itinerary){
        $this->authorize('isOwner', $itinerary);
        return view('itinerary.confirmDelete')->with('itinerary', $itinerary);
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
            return 'errore 404';
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
            $query->where('visibility', 'public');

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

    public function user_itineraries(){
        $itineraries = Itinerary::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('itinerary.userItineraries')
        ->with('itineraries', $itineraries);
    }
}
