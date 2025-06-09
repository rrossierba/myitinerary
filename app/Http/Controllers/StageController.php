<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Stage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StageController extends Controller
{
    public function create($itinerary)
    {   
        $itinerary_obj = Itinerary::find($itinerary);
        $this->authorize('isOwner', arguments: $itinerary_obj);
        return view('stage.editStage')->with('itinerary', $itinerary_obj);
    }

    public function add($itinerary)
    {   
        $itinerary_obj = Itinerary::find($itinerary);
        $this->authorize('isOwner', arguments: $itinerary_obj);
        return view('stage.editStage')
        ->with('itinerary', $itinerary_obj)
        ->with('fromModify', true);
    }

    public function store(Request $request)
    {
        $itinerary = $request->input('itineraryId');
        $this->authorize('isOwner', Itinerary::find($itinerary));
        
        $stage=Stage::create([
            'location'=>$request->input('inputLocation'),
            'description'=>$request->input('textDescription'),
            'duration'=>$request->input('inputDuration'),
            'cost'=>$request->input('inputPrice'),
            'itinerary_id'=>$itinerary,
        ]);

        if($request->input('submit')=='save'){
            return Redirect::to(route('home'));
        }
        elseif($request->input('submit')=='another'){
            return Redirect::to(route('stage.create', ['itinerary'=>$stage->itinerary]));
        }
        else{
            return response()->view('errors.404', [], 404);
        }
    }

    public function edit(Stage $stage)
    {
        $this->authorize('isOwner', $stage->itinerary);
        return view('stage.editStage')
        ->with('stage', $stage);
    }

    public function update(Request $request, Stage $stage)
    {
        $this->authorize('isOwner', $stage->itinerary);
        $stage->update([
            'location'=>$request->input('inputLocation'),
            'description'=>$request->input('textDescription'),
            'duration'=>$request->input('inputDuration'),
            'cost'=>$request->input('inputPrice'),
        ]);
        return Redirect::to(route('itinerary.edit', ['itinerary'=>$stage->itinerary]));
    }

    public function destroy(Stage $stage)
    {
        $itinerary = $stage->itinerary;
        $this->authorize('edit', $itinerary);
        $stage->delete();
        return Redirect::to(route('itinerary.edit',['itinerary'=>$itinerary]));
    }

    public function destroyConfirm(Stage $stage){
        $this->authorize('edit', $stage->itinerary);
        $this->authorize('isOwner', $stage->itinerary);
        return view('stage.confirmDelete')
        ->with('stage', $stage);
    }
}
