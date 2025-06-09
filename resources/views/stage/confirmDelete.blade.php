@extends('layouts.master')

@section('title', 'Elimina tappa')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">I miei Itinerari</li>
    <li class="breadcrumb-item active">Modifica Itinerario</li>
@endsection

@section('body')

    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-12">
                <header>
                    <h2>
                        Eliminare la tappa "{{ $stage->location }}"
                    </h2>
                </header>
                <p class="confirm">
                    Stai elmininando definitivamente la tappa. Confermare?
                </p>
            </div>
        </div>
        <div class="row">
            <form name="stage.delete" method="post" action="{{ route('stage.destroy', ['stage' => $stage]) }}">
                @method('DELETE')
                @csrf
                <input id="mySubmit" class="d-none" type="submit" value="Delete">
            </form>
            <div class="col-6">
                <a class="btn btn-secondary w-100" href="{{ route('itinerary.edit', ['itinerary' => $stage->itinerary]) }}"><i
                        class="bi bi-box-arrow-left"></i> Annulla</a>
            </div>
            <div class="col-6">
                <label for="mySubmit" class="btn btn-danger w-100"><i class="bi bi-trash"></i> Elimina</label>
            </div>
        </div>
    </div>

@endsection