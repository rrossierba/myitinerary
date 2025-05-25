@extends('layouts.master')

@section('title', 'Itinerario')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Itinerari</li>
    <li class="breadcrumb-item active">{{ $itinerary->city->name }}</li>
@endsection

@section('body')
    <div class="row g-4">
        <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h3 class="card-title">{{ $itinerary->title }}</h3>
                    <p>{{$itinerary->city->name}}</p>
                    <p>Prezzo: {{ $itinerary->price }}€</p>
                    @if ($itinerary->stages)
                        @foreach ($itinerary->stages as $stage)
                            <p>{{ $stage->location }}</p>                        
                        @endforeach
                    @else
                        <p class="text-muted">Nessuna descrizione per l'itinerario.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Dettagli itinerario</h5>
                    <p><strong>Like:</strong> {{ $itinerary->favourites->count()}} ❤️ </p>
                    <p><strong>Creato da:</strong> {{ $itinerary->user->name}}</p>
                    <p><strong>Visibilità:</strong> {{ $itinerary->visibility }}</p>
                    
                    @if (auth()->check())
                        <hr>
                        @if (auth()->user()->id == $itinerary->user->id)
                            <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary->id]) }}"
                                class="btn btn-primary w-100 mb-2">Edit</a>
                        @else
                            @if($itinerary->isFavouriteByUser(auth()->id()))
                                <form action="{{ route('favourites.remove', ['favourite'=>$itinerary->getFavouriteByUserId(auth()->id())->id]) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="itineraryId" value="{{ $itinerary->id }}">
                                    <input type="submit" class="d-none" id="favouriteSubmit">
                                </form>
                                <label for="favouriteSubmit" class="btn btn-dark w-100 mb-2">
                                    <i class="bi bi-check-lg"></i>
                                    Itinerario salvato
                                </label>
                            @else
                                <form action="{{ route('favourites.add') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="itineraryId" value="{{ $itinerary->id }}">
                                    <input type="submit" class="d-none" id="favouriteSubmit">
                                </form>
                                <label for="favouriteSubmit" class="btn btn-light w-100 mb-2">
                                    <i class="bi bi-bookmark"></i>
                                    Salva Itinerario
                                </label>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection