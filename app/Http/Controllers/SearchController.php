<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Research;
use App\Models\DTO\Filter;

class SearchController extends Controller
{
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
        $results = Itinerary::where('visibility', 'public')->where('user_id', '!=', auth()->id())->limit(30)->get();
        return view('search.searchResults')->with('itineraries', $results);
        // $query_string = $request->input('q');
        // if ($query_string == '') {
        //     return null;
        // } else {
        //     // create the research object
        //     $research = new Research;
        //     $research->query_string = $query_string;
            
        //     if(auth()->check()) {
        //         $research->user_id = auth()->id();
        //         $research->save();
        //     }
            
        //     // create the query
        //     $titleQuery = Itinerary::query();
        //     $titleQuery->where('visibility', 'public');
        //     if(auth()->check()){
        //         $titleQuery->where('user_id', '!=', auth()->id());
        //     }
        //     $titleQuery->where('title', 'like', '%' . $query_string . '%');
        //     $titleResults = $titleQuery->limit(10)->get();

        //     return response()->json($titleResults);

            // $cityQuery = Itinerary::query();
            // $cityQuery->where('visibility', 'public');
            // if(auth()->check()){
            //     $cityQuery->where('user_id', '!=', auth()->id());
            // }
            // $cityQuery->where('title', 'like', '%' . $query_string . '%');

            
            // $cityQuery->whereHas('city', function ($q) use ($query_string) {
            //     $q->where('name', 'like', '%' . $query_string . '%');
            // });
            // $cityResults = $cityQuery->get();

            // return view('search.searchResults')
            //     ->with('itineraries', $results)
            //     ->with('research', $research);
        // }
    }
}
