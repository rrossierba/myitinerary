@extends('layouts.master')

@section('title')
    @if (isset($itinerary))
        Modifica Itinerario
    @else
        Crea Itinerario
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Gestisci Itinerari</li>
    @if (isset($itinerary))
        <li class="breadcrumb-item active">Modifica Itinerario</li>
    @else
        <li class="breadcrumb-item active">Crea Itinerario</li>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // visualizzazione dinamica bottone modifica
            @if (isset($itinerary))
                var fields = ['input[name=inputTitle]', 'input[name=citySelector]'];
                var initialValues = fields.map((field) => $(field).val().trim());
                fields.forEach((field, index) => {
                    $(field).on('input', function () {
                        let changed = false;
                        for (let i = 0; i < fields.length; i++) {
                            if ($(fields[i]).val().trim() !== initialValues[i]) {
                                changed = true;
                                break;
                            }
                        }
                        $('#submitButton').toggle(changed);
                    });
                });
            @endif

            // autocompletamento delle città
            $('input[name=citySelector]').on('input', function () {
                const query = $(this).val();

                if (query.length < 2) {
                    $('#citySuggestions').empty();
                    return;
                }
                $.ajax({
                    url: '{{ route('api.city.name') }}',
                    data: { q: query },
                    success: function (data) {
                        $('#citySuggestions').empty();

                        data.forEach(city => {
                            $('#citySuggestions').append(
                                `<li class="list-group-item list-group-item-action"> 
                                            ${city.name} (${city.region}, ${city.state})
                                            </li>`
                            );
                        });
                    }
                });
            });

            $(document).on('click', '#citySuggestions li', function () {
                $('input[name=citySelector]').val($(this).text().trim()).trigger('input');
                $('#citySuggestions').empty();
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('#cityInput, #citySuggestions').length) {
                    $('#citySuggestions').empty();
                }
            });

            // controllo della form
            $('form[name=itinerary]').submit(function (event) {
                event.preventDefault();
                var error = false;

                // controllo su titolo
                if ($('input[name=inputTitle]').val().trim() === '') {
                    error = true;
                    $('#invalidTitle').text('Il titolo è obbligatorio');
                    $('input[name=inputTitle]').addClass('invalidFocus');
                    $('input[name=inputTitle]').focus();
                } else {
                    $('input[name=inputTitle]').removeClass('invalidFocus');
                    $('#invalidTitle').empty();
                }

                // controllo su città
                if (!error && $('input[name=citySelector]').val().trim() === '') {
                    error = true;
                    $('#invalidCity').text('La città è obbligatoria');
                    $('input[name=citySelector]').addClass('invalidFocus');
                    $('input[name=citySelector]').focus();
                } else if (!error && !$('input[name=citySelector]').val().trim().match(/^(.+?) \((.+?), (.+?)\)$/)) {
                    error = true;
                    $('#invalidCity').text('Forma errata: Nome (Regione, Stato)');
                    $('input[name=citySelector]').addClass('invalidFocus');
                    $('input[name=citySelector]').focus();
                }
                else {
                    $('input[name=citySelector]').removeClass('invalidFocus');
                    $('#invalidCity').empty();
                }

                if (!error) {
                    // controllo se la città esiste
                    $.ajax({
                        url: '{{ route('api.city.exist') }}',
                        async: true,
                        data: {
                            cityString: $('input[name=citySelector]').val()
                        },
                        success: function (data) {
                            if (data.error) {
                                $('#errorModal .modal-body').html('Città definita in modo errato <br> La città deve essere scritta come ');
                            }
                            if (data.exist == false) {
                                $('#errorModal .modal-body').html(`Città “${$('input[name=citySelector]').val()}” non definita`);
                                var modal = new bootstrap.Modal(document.getElementById('errorModal'));
                                modal.show();
                            } else
                                $("form[name='itinerary'")[0].submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection

@section('body')
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Errore</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    @if (isset($itinerary))
        <form name="itinerary" method="post" action="{{ route('itinerary.update', ['itinerary' => $itinerary->id]) }}">
            @method('PUT')
    @else
            <form name="itinerary" method="post" action="{{ route('itinerary.store') }}">
        @endif

            @csrf

            <div class="row justify-content-end mb-2">
                <div class="col-lg-2 col-md-4 col-6">
                    <input type="submit" class="d-none" id="editSubmit">
                    @if (isset($itinerary))
                        <label for="editSubmit" id="submitButton" class="btn btn-success w-100" style="display: none"><i
                                class="bi bi-floppy"></i> Salva</label>
                    @else
                        <label for="editSubmit" class="btn btn-success w-100"><i class="bi bi-pencil"></i> Aggiungi
                            tappe</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    @if (isset($itinerary))
                        <a href="{{ url()->previous() }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
                    @else
                        <a href="{{ url()->previous() }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
                    @endif
                </div>
            </div>

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
                    <span class="invalidInput" id="invalidTitle"></span>
                </div>
            </div>

            <div class="row mb-3">
                <!-- città -->
                <div class="col-lg-2 col-md-3 col-12">
                    <label for="inserCity" class="form-label">Seleziona la Città</label>
                </div>
                <div class="col-lg-4 col-md-9 col-12 position-relative">
                    @if (isset($itinerary))
                        <input type="text" class="form-control w-100" autocomplete="off" name="citySelector"
                            placeholder="Inserisci una città" id="cityInput"
                            value="{{ $itinerary->city->name }} ({{ $itinerary->city->region }}, {{ $itinerary->city->state }})">
                    @else
                        <input type="text" class="form-control w-100" id="cityInput" autocomplete="off" name="citySelector"
                            placeholder="Inserisci una città">
                    @endif
                    <span class="invalidInput" id="invalidCity"></span>
                    <ul id="citySuggestions" class="list-group position-absolute" style="z-index: 1000;"></ul>
                </div>

                <!-- visibilità -->
                <div class="col-lg-1 col-md-2 col-6">
                    <label>Visibilità</label>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
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
            </div>
        </form>

        @if (isset($itinerary->stages))
            @if ($itinerary->stages->count() > 0)
                <h3>Modifica tappe</h3>
                <ul class="list-group">
                    @foreach ($itinerary->stages as $stage)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-4 col-6">
                                    {{ $stage->location }}
                                </div>
                                <div class="col-lg-2 col-3">
                                    Prezzo: {{ $stage->cost }} €
                                </div>
                                <div class="col-lg-2 col-3">
                                    Durata: {{ $stage->duration }} min.
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="{{ route('stage.edit', ['stage' => $stage]) }}" class="btn btn-primary mb-2 w-100"><i
                                            class="bi bi-pencil"></i> Modifica Tappa</a>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="{{ route('stage.destroy.confirm', ['stage' => $stage]) }}"
                                        class="btn btn-danger mb-2 w-100"><i class="bi bi-trash"></i> Elimina</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <div class="row justify-content-center mt-2">
                <div class="col-6">
                    <a href="{{ route('stage.add', ['itinerary' => $itinerary]) }}" class="btn btn-primary w-100"><i
                            class="bi bi-plus"></i> Aggiungi tappa</a>
                </div>
            </div>
        @endif
@endsection