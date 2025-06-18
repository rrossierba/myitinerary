@extends('layouts.master')

@section('title', 'Itinerario')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    @if (auth()->check() && auth()->user()->can('owns', $itinerary))
        <li class="breadcrumb-item">Gestisci Itinerari</li>
        <li class="breadcrumb-item">I miei Itinerari</li>
    @else
        <li class="breadcrumb-item">Itinerari</li>
    @endif
    <li class="breadcrumb-item active">{{ $itinerary->city->name }}</li>
@endsection

@section('scripts')
    @if(auth()->check() && auth()->user()->cannot('owns', $itinerary))
        <script>
            $(document).ready(function () {
                function handleRemoveSaved(buttonElement) {
                    $.ajax({
                        url: '{{ route('favourites.remove') }}',
                        method: 'DELETE',
                        data: {
                            itinerary_id: {{ $itinerary->id }},
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.deleted === true) {
                                buttonElement.html(`<i class="bi bi-bookmark"></i> Salva`);
                                buttonElement.removeClass('btn-secondary saved');
                                buttonElement.addClass('btn-outline-secondary toSave');
                                buttonElement.off('click');
                                buttonElement.on('click', function () {
                                    handleAddSaved($(this));
                                });

                                favourite = $(`#favouriteNumber`);
                                favourite_number = favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number - 1)

                            } else {
                                console.warn('Errore nella rimozione (server ha risposto ma non deleted=true):', data);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Errore Ajax nella rimozione:', error);
                        }
                    });
                }

                function handleAddSaved(buttonElement) {
                    const itinerary_id = buttonElement.attr('itineraryid');

                    $.ajax({
                        url: '{{ route('favourites.add') }}',
                        method: 'POST',
                        data: {
                            itinerary_id: {{ $itinerary->id }},
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.created === true) {
                                buttonElement.html(`<i class="bi bi-check-lg"></i> Salvato`);
                                buttonElement.removeClass('btn-outline-secondary toSave');
                                buttonElement.addClass('btn-secondary saved');

                                buttonElement.off('click');
                                buttonElement.on('click', function () {
                                    handleRemoveSaved($(this));
                                });

                                favourite = $(`#favouriteNumber`);
                                favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number + 1)

                            } else {
                                console.warn('Errore nell\'aggiunta (server ha risposto ma non created=true):', data);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Errore Ajax nell\'aggiunta:', error);
                        }
                    });
                }

                $('.toSave').on('click', function (e) {
                    handleAddSaved($(this), '{{ route('favourites.add') }}');
                });

                $('.saved').on('click', function (e) {
                    handleRemoveSaved($(this));
                });
            });

        </script>
    @endif
@endsection

@section('body')
    <div class="row g-4 mb-2">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h3 class="card-title">{{ $itinerary->title }}</h3>
                    <p>{{$itinerary->city->name}}</p>
                    <p>Prezzo totale: {{ number_format($itinerary->stages->sum('cost'), 2, ',', '.') }} €</p>
                    <p>Tappe: {{ $itinerary->stages->count() }}</p>
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-5 col-12">
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
                                            </div> -->

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h5 class="mb-3">Dettagli itinerario</h5>
                    <p><strong>Salvataggi:</strong> <span id="favouriteNumber">{{ $itinerary->favourites->count()}}</span>
                        <i class="text-danger bi bi-heart-fill"></i>
                    </p>
                    <p><strong>Creato da:</strong> {{ $itinerary->user->name}}</p>
                    <p><strong>Visibilità:</strong> {{ $itinerary->visibility }}</p>

                    <!-- bottoni -->
                    @if (auth()->check())
                        <hr>
                        </hr>
                        @if (auth()->user()->id == $itinerary->user->id)
                            <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary->id]) }}"
                                class="btn btn-primary w-100 mb-2">Edit</a>
                            <a href="{{ route('itinerary.destroy.confirm', ['itinerary' => $itinerary]) }}"
                                class="btn btn-danger w-100 mb-2">Elimina</a>
                        @else
                            @if ($itinerary->isFavouriteByUser(auth()->id()))
                                <button class="btn btn-secondary w-100 mb-2 saved" itineraryid="{{ $itinerary->id }}">
                                    <i class="bi bi-check-lg"></i>
                                    Salvato
                                </button>
                            @else
                                <button class="btn btn-outline-secondary w-100 mb-2 toSave" itineraryid="{{ $itinerary->id }}">
                                    <i class="bi bi-bookmark"></i>
                                    Salva
                                </button>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- tappe -->
    <div class="row">
        @if (count($itinerary->stages) > 0)
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
        @endif
    </div>
@endsection