<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Research;
use App\Models\DTO\Filter;
use Illuminate\Support\Facades\Redirect;

class SearchController extends Controller
{
    public function searchIndex()
    {
        if (auth()->user() == null) {
            $history = [];
        } else {
            $history = Research::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->limit(5)->get();
        }

        return view('search.searchPage')
            ->with('history', $history);
    }

    public function search(Request $request){
        
        $request->validate([
            'query'=>['required','string'],
            'history'=>['nullable']
        ]);

        $query_string = trim(strip_tags($request->input('query')));

        $research = new Research;
        $research->query_string = $query_string;

        $history = $request->input('history')==null?false:true;
        
        if (auth()->check() && !$history) {
            $research->user_id = auth()->id();
            $research->save();
        }

        return Redirect::to(route('search.results', ['query'=>$query_string]));
    }

    public function search_results($query)
    {
        $itineraries = Itinerary::where('visibility', 'public')
        ->when(auth()->check(), function ($query) {
            $query->where('user_id', '!=', auth()->id());
        })
        ->where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                  ->orWhereHas('city', function ($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
        })
        ->paginate(20);

        return view('search.searchResults')->with(compact('itineraries'))->with('search', true)->with('query', $query);
    }

}




