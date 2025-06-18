<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StageController extends Controller
{
    // public function add($itinerary)
    // {
    //     $itinerary_obj = Itinerary::find($itinerary);
    //     $this->authorize('isOwner', arguments: $itinerary_obj);
    //     return view('stage.editStage')
    //         ->with('itinerary', $itinerary_obj);
    // }

    // public function store2(Request $request)
    // {
    //     $request->validate([
    //         'itineraryId' => ['required', 'integer'],
    //         'inputLocation' => ['required', 'string', 'max:255'],
    //         'textDescription' => ['nullable', 'string'],
    //         'inputDuration' => ['nullable', 'integer'],
    //         'cost' => ['nullable', 'numeric']
    //     ]);

    //     $itinerary = $request->input('itineraryId');
    //     $this->authorize('isOwner', Itinerary::find($itinerary));

    //     $stage = Stage::create([
    //         'location' => $request->input('inputLocation'),
    //         'description' => $request->input('textDescription'),
    //         'duration' => $request->input('inputDuration') != null ? $request->input('inputDuration') : 0,
    //         'cost' => $request->input('inputPrice') != null ? $request->input('inputPrice') : 0.0,
    //         'itinerary_id' => $itinerary,
    //     ]);

    //     return Redirect::to(route('itinerary.edit', ['itinerary'=>$stage->itinerary]));

    // }

    public function create(Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);
        return view('stage.editStage')->with('itinerary', $itinerary);
    }

    public function store(Request $request, Itinerary $itinerary)
    {
        $request->validate([
            'inputLocation' => ['required','array'],
            'inputLocation.*' => ['required','string'],
            'inputPrice' => ['required','array'],
            'inputPrice.*' => ['nullable','numeric','min:0'],
            'inputDuration' => ['required','array'],
            'inputDuration.*' => ['nullable','integer','min:0'],
            'textDescription' => ['required','array'],
            'textDescription.*' => ['nullable','string'],
        ]);

        $locations = $request->input('inputLocation');
        $prices = $request->input('inputPrice');
        $durations = $request->input('inputDuration');
        $descriptions = $request->input('textDescription');
    
        foreach ($locations as $index => $location) {
            Stage::create([
                'itinerary_id' => $itinerary->id,
                'location' => $location,
                'cost' => $prices[$index] != null? $prices[$index]:0.0,
                'duration' => $durations[$index] != null? $durations[$index]:0,
                'description' => $descriptions[$index] ?? null,
            ]);
        }
    
        return redirect()->route('itinerary.edit', ['itinerary' => $itinerary->id])
                         ->with('success', 'Tappe salvate con successo.');
    }
    

    public function edit(Stage $stage)
    {
        $this->authorize('isOwner', $stage->itinerary);
        return view('stage.editStage')
            ->with('stage', $stage)
            ->with('itinerary', $stage->itinerary);
    }

    public function update(Request $request, Stage $stage)
    {
        $this->authorize('isOwner', $stage->itinerary);

        $request->validate([
            'inputLocation' => ['required', 'string', 'max:255'],
            'textDescription' => ['nullable', 'string'],
            'inputDuration' => ['nullable', 'integer'],
            'cost' => ['nullable', 'numeric']
        ]);

        $stage->update([
            'location' => $request->input('inputLocation'),
            'description' => $request->input('textDescription'),
            'duration' => $request->input('inputDuration') != null ? $request->input('inputDuration') : 0,
            'cost' => $request->input('inputPrice') != null ? $request->input('inputPrice') : 0.0,
        ]);
        return Redirect::to(route('itinerary.edit', ['itinerary' => $stage->itinerary]));
    }

    public function destroy(Stage $stage)
    {
        $itinerary = $stage->itinerary;
        $this->authorize('isOwner', $itinerary);
        $stage->delete();
        return Redirect::to(route('itinerary.edit', ['itinerary' => $itinerary]));
    }

    public function destroyConfirm(Stage $stage)
    {
        $this->authorize('isOwner', $stage->itinerary);
        return view('stage.confirmDelete')
            ->with('stage', $stage);
    }
}
