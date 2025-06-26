<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StageController extends Controller
{
    public function create(Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);
        return view('stage.editStage')->with('itinerary', $itinerary);
    }

    public function add(Itinerary $itinerary)
    {
        $this->authorize('isOwner', $itinerary);
        return view('stage.editStage')->with('itinerary', $itinerary)->with('add', true);
    }

    public function store(Request $request, Itinerary $itinerary)
    {
        $request->validate([
            'inputLocation' => ['required', 'array'],
            'inputLocation.*' => ['required', 'string'],
            'inputPrice' => ['required', 'array'],
            'inputPrice.*' => ['nullable', 'numeric', 'min:0'],
            'inputDuration' => ['required', 'array'],
            'inputDuration.*' => ['nullable', 'integer', 'min:0'],
            'textDescription' => ['required', 'array'],
            'textDescription.*' => ['nullable', 'string'],
        ]);

        $locations = $request->input('inputLocation');
        $prices = $request->input('inputPrice');
        $durations = $request->input('inputDuration');
        $descriptions = $request->input('textDescription');

        $redirectToIndex = $itinerary->stages->count() == 0;

        foreach ($locations as $index => $location) {
            Stage::create([
                'itinerary_id' => $itinerary->id,
                'location' => $location,
                'cost' => $prices[$index] != null ? $prices[$index] : 0.0,
                'duration' => $durations[$index] != null ? $durations[$index] : 0,
                'description' => $descriptions[$index] ?? null,
            ]);
        }

        return $redirectToIndex ?
            redirect()->route('itinerary.index') :
            redirect()->route('itinerary.edit', compact('itinerary'));
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
