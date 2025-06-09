@extends('layouts.master')

@section('title', 'Itinerario')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Itinerari</li>
    <li class="breadcrumb-item active">{{ $itinerary->city->name }}</li>
@endsection

@section('body')
    <div class="row g-4 mb-2">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h3 class="card-title">{{ $itinerary->title }}</h3>
                    <p>{{$itinerary->city->name}}</p>
                    <p>Prezzo totale: {{ number_format($itinerary->stages->sum('cost'), 2, ',', '.') }} €</p>
                    <p>Tappe: {{ $itinerary->stages->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-12">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/img/all-itineraries.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Informazioni su tutti i viaggi</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="/img/search-itinerary.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/img/create-itinerary.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h5 class="mb-3">Dettagli itinerario</h5>
                    <p><strong>Like:</strong> {{ $itinerary->favourites->count()}} ❤️ </p>
                    <p><strong>Creato da:</strong> {{ $itinerary->user->name}}</p>
                    <p><strong>Visibilità:</strong> {{ $itinerary->visibility }}</p>

                    @if (auth()->check())
                        <hr>
                        @if (auth()->user()->id == $itinerary->user->id)
                            <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary->id]) }}" class="btn btn-primary w-100 mb-2">Edit</a>
                            <a href="{{ route('itinerary.destroy.confirm', ['itinerary'=>$itinerary]) }}" class="btn btn-danger w-100 mb-2">Elimina</a>
                        @else
                            @if($itinerary->isFavouriteByUser(auth()->id()))
                                <form
                                    action="{{ route('favourites.remove', ['favourite' => $itinerary->getFavouriteByUserId(auth()->id())->id]) }}"
                                    method="post">
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
    <div class="row">
        @if ($itinerary->stages)
            <h4>Tappe</h4>
            <div class="accordion" id="stagesAccordion">
                @foreach ($itinerary->stages as $stage)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $stage->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $stage->id }}">
                                {{$stage->location}}
                            </button>
                        </h2>
                        <div id="collapse{{ $stage->id }}" class="accordion-collapse collapse" data-bs-parent="#stagesAccordion">
                            <div class="accordion-body">
                                <p><strong>Descrizione</strong><br>
                                {{ $stage->description }}</p>
                                <p><strong>Prezzo</strong>: {{ $stage->cost }} €</p>
                                <p><strong>Durata</strong>: {{ $stage->duration }} minuti</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Nessuna descrizione per l'itinerario.</p>
        @endif
    </div>
@endsection