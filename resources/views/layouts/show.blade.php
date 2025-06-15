@extends('layouts.master')

@section('body')

    @yield('before_results')

    @foreach ($itineraries as $itinerary)
        <div class="card mb-2 shadow-sm rounded p-3 mb-3">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-lg-10 col-8">
                        <h5 class="card-title">
                            <a href="{{ route('itinerary.show', ['itinerary' => $itinerary]) }}"
                                class="link-underline-opacity-0 link-dark">{{ $itinerary->title }}</a>
                        </h5>
                    </div>
                    <div class="col-lg-2 col-4">
                        @if (auth()->check())
                            @if(auth()->user()->can('isOwner', $itinerary))
                                <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary]) }}"
                                    class="btn btn-outline-secondary w-100 mb-2">
                                    <i class="bi bi-pencil"></i>
                                    Edit
                                </a>
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

                <div class="row g-2">
                    <div class="col-lg-10 col-8">
                        <div class="badge bg-secondary fs-6 mb-2">
                            <i class="bi bi-globe-europe-africa"></i>
                            {{ $itinerary->city->name }}
                        </div>
                        <div class="badge bg-primary fs-6 mb-2">
                            <i class="bi bi-currency-euro"></i>
                            {{ number_format($itinerary->stages->sum('cost'), 2, ',', '.') }}
                        </div>
                        <div class="badge bg-success fs-6 mb-2">
                            <i class="bi bi-person-fill"></i>
                            {{ $itinerary->user->name }}
                        </div>
                        <div class="badge bg-light fs-6 mb-2 text-dark">
                            <i class="bi bi-eye"></i>
                            {{ $itinerary->visibility }}
                        </div>
                    </div>

                    <div class="col-lg-2 col-4">
                        <div class="badge bg-danger fs-6 mb-2 w-100">
                            <i class="bi bi-heart-fill"></i>
                            <span id="favourite{{ $itinerary->id }}">
                                {{ $itinerary->favourites->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @yield('after_results')

    @if (auth()->check())
        <script>
            $(document).ready(function () {

                // Funzione per gestire la rimozione dei preferiti
                function handleRemoveSaved(buttonElement) {
                    const itinerary_id = buttonElement.attr('itineraryid');
                    console.log('Tentativo di rimozione preferito per ID:', itinerary_id);

                    $.ajax({
                        url: '{{ route('favourites.remove') }}',
                        method: 'DELETE', // O il metodo HTTP corretto che accetta Laravel per la rimozione
                        data: {
                            itinerary_id: itinerary_id,
                            _token: '{{ csrf_token() }}' // Aggiungi il token CSRF per le richieste POST
                        },
                        success: function (data) {
                            if (data.deleted === true) { // Usa === per confronto stretto
                                console.log('Preferito rimosso con successo:', data);
                                buttonElement.html(`<i class="bi bi-bookmark"></i> Salva`);
                                buttonElement.removeClass('btn-secondary saved');
                                buttonElement.addClass('btn-outline-secondary toSave');

                                // Rimuovi l'handler di 'removeSaved' e aggiungi quello di 'addSaved'
                                buttonElement.off('click'); // Rimuovi tutti gli handler precedenti per questo elemento
                                buttonElement.on('click', function () { // Aggiungi il nuovo handler
                                    handleAddSaved($(this));
                                });

                                favourite = $(`#favourite${itinerary_id}`);
                                favourite_number = favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number - 1)

                            } else {
                                console.warn('Errore nella rimozione (server ha risposto ma non deleted=true):', data);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Errore Ajax nella rimozione:', error);
                            // Gestisci l'errore lato utente
                        }
                    });
                }

                // Funzione per gestire l'aggiunta ai preferiti
                function handleAddSaved(buttonElement) {
                    const itinerary_id = buttonElement.attr('itineraryid');
                    console.log('Tentativo di aggiunta preferito per ID:', itinerary_id);

                    $.ajax({
                        url: '{{ route('favourites.add') }}',
                        method: 'POST', // O il metodo HTTP corretto che accetta Laravel per l'aggiunta
                        data: {
                            itinerary_id: itinerary_id,
                            _token: '{{ csrf_token() }}' // Aggiungi il token CSRF per le richieste POST
                        },
                        success: function (data) {
                            if (data.created === true) { // Usa === per confronto stretto
                                console.log('Preferito aggiunto con successo:', data);
                                buttonElement.html(`<i class="bi bi-check-lg"></i> Salvato`); // Icona di "salvato"
                                buttonElement.removeClass('btn-outline-secondary toSave');
                                buttonElement.addClass('btn-secondary saved');

                                // Rimuovi l'handler di 'addSaved' e aggiungi quello di 'removeSaved'
                                buttonElement.off('click'); // Rimuovi tutti gli handler precedenti
                                buttonElement.on('click', function () { // Aggiungi il nuovo handler
                                    handleRemoveSaved($(this));
                                });

                                favourite = $(`#favourite${itinerary_id}`);
                                favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number + 1)

                            } else {
                                console.warn('Errore nell\'aggiunta (server ha risposto ma non created=true):', data);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Errore Ajax nell\'aggiunta:', error);
                            // Gestisci l'errore lato utente
                        }
                    });
                }

                $('.toSave').on('click', function (e) {
                    handleAddSaved($(this));
                });

                $('.saved').on('click', function (e) {
                    handleRemoveSaved($(this));
                });


            });
        </script>
    @endif

@endsection