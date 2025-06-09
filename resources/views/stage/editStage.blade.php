@extends('layouts.master')

@section ('title', 'Aggiungi tappa')

@section('breadcrumb')
    @if (isset($stage))
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">I miei Itinerari</li>
        <li class="breadcrumb-item">Modifica Itinerario</li>
        <li class="breadcrumb-item active">{{ $itinerary->title }}</li>
    @else
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">I miei Itinerari</li>
        <li class="breadcrumb-item">Crea Itinerario</li>
        <li class="breadcrumb-item active">{{ $itinerary->title }}</li>
    @endif
@endsection

@section('body')
    @if (isset($stage))
        <form action="{{ route('stage.update', ['stage' => $stage]) }}" method="post">
        @method('put')
    @else
        <form action="{{ route('stage.store') }}" method="post">
        <input type="hidden" name="itineraryId" value="{{ $itinerary->id }}">
    @endif
        @csrf
        <div class="row mb-2 justify-content-end">
            @if (isset($stage))
            <!-- modifica una tappa -->
            <div class="col-lg-2 col-md-4 col-6">
                <input type="submit" name="submit" id="submitModify" class="d-none" value="modify">
                <label for="submitModify" class="btn btn-success w-100"><i class="bi bi-pencil"></i> Modifica</label>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{ route('itinerary.edit', ['itinerary'=>$stage->itinerary->id]) }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
            </div>
            @elseif(isset($fromModify))
            <!-- aggiungi una tappa dalla pagina di modifica -->
            <div class="col-lg-2 col-md-4 col-6">
                <input type="submit" name="submit" id="submitModify" class="d-none" value="modify">
                <label for="submitModify" class="btn btn-success w-100"><i class="bi bi-pencil"></i> Aggiungi</label>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <a href="{{ route('itinerary.edit', ['itinerary'=>$itinerary]) }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
            </div>
            @else 
            <!-- aggiungi una tappa quando si crea l'itinerario-->
            <div class="col-lg-2 col md-3 col-4">
                <input type="submit" name="submit" id="submitAnother" class="d-none" value="another">
                <label for="submitAnother" class="btn btn-success w-100"><i class="bi bi-pencil"></i> Altra tappa</label>
            </div>
            <div class="col-lg-2 col md-3 col-4">
                <input type="submit" name="submit" id="submitSave" class="d-none" value="save">
                <label for="submitSave" class="btn btn-success w-100"><i class="bi bi-floppy"></i> Salva itinerario</label>
            </div>
            <div class="col-lg-2 col md-3 col-4">
                @if (isset($fromModify))
                <a href="{{ route('itinerary.edit', ['itinerary'=>$itinerary]) }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
                @else
                <a href="{{ route('home') }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
                @endif
            </div>
            @endif
        </div>
        <div class="row mb-2">
            <div class="col-md-2 col-sm-12">
                <label for="inputLocation">Luogo</label>
            </div>
            <div class="col-md-10 col-sm-12">
                @if (isset($stage))
                <input type="text" class="form-control" id="inputLocation" name="inputLocation" value="{{ $stage->location }}">
                @else
                <input type="text" class="form-control" id="inputLocation" name="inputLocation">
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-4 mb-2">
                <label for="inputPrice">Prezzo:</label>
            </div>
            <div class="col-md-4 col-8 mb-2">
                @if (isset($stage))
                <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000" class="form-control" step="0.01" value="{{ $stage->cost }}">
                @else
                <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000" class="form-control" step="0.01">
                @endif
            </div>
            <div class="col-md-2 col-4 mb-2">
                <label for="inputDuration">Durata (min):</label>
            </div>
            <div class="col-md-4 col-8 mb-2">
                @if (isset($stage))
                <input type="number" id="inputDuration" name="inputDuration" min="0" max="1000" class="form-control" value="{{ $stage->duration }}">
                @else
                <input type="number" id="inputDuration" name="inputDuration" min="0" max="1000" class="form-control">
                @endif
            </div>
        </div>
        @if (isset($noSet))
            <div class="row mb-2">
                <div class="col-md-2 col-sm-12">
                    <label for="stagePhoto">Carica una foto:</label>
                </div>
                <div class="col-md-10 col-sm-12">
                    <input type="file" id="stagePhoto" name="stagePhoto" accept="image/png, image/jpeg" class="form-control" />
                </div>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-md-2 col-sm-12">
                <label for="textDescription">Descrizione:</label>
            </div>
            <div class="col-md-10 col-sm-12">
                @if (isset($stage))
                <textarea name="textDescription" id="textDescription" rows="4" class="form-control">{{ $stage->description }}</textarea>
                @else
                <textarea name="textDescription" id="textDescription" rows="4" class="form-control"></textarea>
                @endif
            </div>
        </div>


    </form>
@endsection