@extends('layouts.master')

@section ('title', 'Aggiungi tappa')

@section('breadcrumb')
    @if (isset($itinerary))
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">I miei Itinerari</li>
        <li class="breadcrumb-item active">Modifica Itinerario</li>
    @else
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">I miei Itinerari</li>
        <li class="breadcrumb-item active">Crea Itinerario</li>
    @endif
@endsection

@section('body')
    <form action="{{ route('stage.store') }}" method="post">
        @csrf
        <div class="row mb-2">
            <div class="col-md-2 col-12">
                <label for="itinerarySelect">Itinerario</label>
            </div>
            <div class="col-md-10 col-12">
                <select name="itinerarySelect" id="itinerarySelect" class="form-select">
                    @foreach ($itineraries as $itinerary)
                    <option value="{{ $itinerary->id }}">{{ $itinerary->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2 col-sm-12">
                <label for="inputLocation">Luogo</label>
            </div>
            <div class="col-md-10 col-sm-12">
                <input type="text" class="form-control" id="inputLocation">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-4 mb-2">
                <label for="inputPrice">Prezzo:</label>
            </div>
            <div class="col-md-4 col-8 mb-2">
                <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000" class="form-control" step="0.01">
            </div>
            <div class="col-md-2 col-4 mb-2">
                <label for="inputDuration">Durata (min):</label>
            </div>
            <div class="col-md-4 col-8 mb-2">
                <input type="number" id="inputDuration" name="inputDuration" min="0" max="1000" class="form-control">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2 col-sm-12">
                <label for="stagePhoto">Carica una foto:</label>
            </div>
            <div class="col-md-10 col-sm-12">
                <input type="file" id="stagePhoto" name="stagePhoto" accept="image/png, image/jpeg" class="form-control" />
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2 col-sm-12">
                <label for="textDescription">Descrizione:</label>
            </div>
            <div class="col-md-10 col-sm-12">
                <textarea name="textDescription" id="textDescription" rows="4" class="form-control"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                <input type="submit" name="submit" id="submitAnother" class="d-none" value="save">
                <label for="submitAnother" class="btn btn-success w-100">Salva e aggiungi una tappa</label>
            </div>
            <div class="col-md-4 col-12">
                <input type="submit" name="submit" id="submitSave" class="d-none" value="another">
                <label for="submitSave" class="btn btn-success w-100">Salva itinerario</label>
            </div>
            <div class="col-md-4 col-12">
                <a href="{{ route('home') }}" class="btn btn-danger w-100">Annulla</a>
            </div>
        </div>
    </form>
@endsection