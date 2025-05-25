@extends('layouts.master')

@section('title')
    @if (isset($itinerary))
        Modifica Itinerario
    @else
        Crea Itinerario
    @endif
@endsection

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

    @if (auth()->check())

        @if (isset($itinerary))
            <form name="itinerary" method="post" action="{{ route('itinerary.update', ['itinerary' => $itinerary->id]) }}">
                @method('PUT')
        @else
                <form name="itinerary" method="post" action="{{ route('itinerary.store') }}">
            @endif

                @csrf
                <!-- titolo -->
                <div class="row mb-3">
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <label for="inputTitle" class="col-form-label">Inserisci titolo</label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        @if (isset($itinerary))
                            <input type="text" id="inputTitle" name="inputTitle" value="{{ $itinerary->title }}"
                                class="form-control">
                        @else
                            <input type="text" id="inputTitle" name="inputTitle" placeholder="Titolo" class="form-control">
                        @endif
                    </div>
                </div>

                <!-- città -->
                <div class="row mb-3">
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <label for="citySelector">Seleziona la Città</label>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <select class="form-select" aria-label="Seleziona Città" id="citySelector" name="citySelector">
                            @if (isset($itinerary))
                                @foreach ($cities as $city)
                                    @if ($city == $itinerary->city)
                                        <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                                    @else
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endif
                                @endforeach
                            @else
                                <option selected>Seleziona una città</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                </div>

                <!-- visibilità e prezzo -->
                <div class="row mb-3">
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <label>Visibilità</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        @if (isset($itinerary))
                            @if ($itinerary->visibility->value == 'public')
                                <input type="radio" class="btn-check" name="visibilitaRadio" id="radioPublic" value="public" checked>
                                <label class="btn btn-light rounded-pill" for="radioPublic">Pubblica</label>
                                <input type="radio" class="btn-check" name="visibilitaRadio" id="radioPrivate" value="private">
                                <label class="btn btn-light rounded-pill" for="radioPrivate">Privata</label>
                            @elseif ($itinerary->visibility->value == 'private')
                                <input type="radio" class="btn-check" name="visibilitaRadio" id="radioPublic" value="public">
                                <label class="btn btn-light rounded-pill" for="radioPublic">Pubblica</label>
                                <input type="radio" class="btn-check" name="visibilitaRadio" id="radioPrivate" value="private" checked>
                                <label class="btn btn-light rounded-pill" for="radioPrivate">Privata</label>
                            @endif
                        @else
                            <input type="radio" class="btn-check" name="visibilitaRadio" id="radioPublic" value="public" checked>
                            <label class="btn btn-light rounded-pill" for="radioPublic">Pubblica</label>

                            <input type="radio" class="btn-check" name="visibilitaRadio" id="radioPrivate" value="private">
                            <label class="btn btn-light rounded-pill" for="radioPrivate">Privata</label>
                        @endif
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        <label for="inputPrice">Prezzo:</label>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-6">
                        @if (isset($itinerary))
                            <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000" class="form-control"
                                value="{{ $itinerary->price }}" step="0.01">
                        @else
                            <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000" class="form-control"
                                step="0.01">
                        @endif
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-4">
                        <input type="submit" class="d-none" id="editSubmit">
                        @if (isset($itinerary))
                            <label for="editSubmit" class="btn btn-success w-100">Modifica e vai alle tappe</label>
                        @else
                            <label for="editSubmit" class="btn btn-success w-100">Salva e aggiungi tappe</label>
                        @endif
                    </div>
                    <div class="col-4">
                        @if (isset($itinerary))
                            <a href="{{ route('itinerary.show', ['itinerary' => $itinerary]) }}"
                                class="btn btn-danger w-100">Annulla</a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-danger w-100">Annulla</a>
                        @endif
                    </div>
                </div>
            </form>
    @else
            <p>Prima di creare itinerari devi effettuare il login</p>

        @endif


@endsection