@extends('layouts.master')

@section ('title')
    @if(isset($stage))
        Modifica Tappa
    @else
        Aggiungi Tappe
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Gestisci Itinerari</li>
    @if (isset($stage))
        <li class="breadcrumb-item">{{ $stage->itinerary->title }}</li>
        <li class="breadcrumb-item active">Modifica Tappa</li>
    @else
        <li class="breadcrumb-item">{{ $itinerary->title }}</li>
        <li class="breadcrumb-item active">Aggiungi Tappe</li>
    @endif
@endsection

@section('scripts')
    <script>
        @if(isset($stage))
            $(document).ready(function () {
                const initialValues = [
                    $('#inputLocation').val().trim(),
                    $('#inputPrice').val(),
                    $('#inputDuration').val(),
                    $('#textDescription').val().trim(),
                ];

                function isChanged() {
                    let changed = !(($('#inputLocation').val().trim() == initialValues[0]) &&
                        ($('#inputPrice').val() == initialValues[1]) &&
                        ($('#inputDuration').val() == initialValues[2]) &&
                        ($('#textDescription').val().trim() == initialValues[3]));
                    return changed
                    
                };
                fields = ['#inputLocation', '#inputPrice', '#inputDuration', '#textDescription'];
                fields.forEach(field => {
                    $(field).on('input', function () {
                        if(isChanged())
                            $('#submitButton').show();
                        else
                            $('#submitButton').hide();
                    });
                });
            });
        @else
            $(document).ready(function () {
                $('#addStage').on('click', function () {
                    let $lastStage = $('.stage-form').last();
                    let $newStage = $lastStage.clone();
                    $newStage.find('input, textarea').val('');
                    $('#stageContainer').append($newStage);
                    $newStage.find('.removeStageBtn').removeClass('d-none');
                });

                $(document).on('click', '.removeStageBtn', function () {
                    if (confirm('Cancellare la tappa?'))
                        $(this).closest('.stage-form').remove();
                });
            });
        @endif
    </script>
@endsection

@section('body')
    @if (isset($stage))
        <form action="{{ route('stage.update', ['stage' => $stage]) }}" method="post">
            @method('put')
    @else
            <form action="{{ route('stage.store', ['itinerary' => $itinerary]) }}" method="post">
        @endif
            @csrf
            <div class="row justify-content-end mb-2">
                <div class="col-lg-2 col-md-4 col-6">
                <input type="submit" name="submit" id="stageSubmit" class="d-none">
                    @if(isset($stage))
                        <label for="stageSubmit" class="btn btn-success w-100" id="submitButton" style="display: none"><i
                                class="bi bi-floppy"></i> Modifica</label>
                    @else
                        <label for="stageSubmit" class="btn btn-success w-100"><i class="bi bi-floppy"></i> Salva</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <a href="{{ url()->previous() }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
                </div>
            </div>
            <div id="stageContainer">
                <div class="stage-form mb-3 justify-content-center">
                    <div class="row">
                        <div class="col-12">
                            <div class="card text-bg-light">
                                <div class="card-body">
                                    <div class="form-floating mb-3">
                                        @if (isset($stage))
                                            <input type="text" class="form-control" id="inputLocation" name="inputLocation"
                                                placeholder="Luogo" value="{{ $stage->location }}" required>
                                        @else
                                            <input type="text" class="form-control" id="inputLocation" name="inputLocation[]"
                                                placeholder="Luogo" required>
                                        @endif
                                        <label for="inputLocation">Luogo</label>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                @if (isset($stage))
                                                    <input type="number" id="inputDuration" name="inputDuration" min="0"
                                                        max="1000" class="form-control" value="{{ $stage->duration }}"
                                                        placeholder="Durata (min)">
                                                @else
                                                    <input type="number" id="inputDuration" name="inputDuration[]" min="0"
                                                        max="1000" class="form-control" placeholder="Durata (min)">
                                                @endif
                                                <label for="inputDuration">Durata (min)</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                @if (isset($stage))
                                                    <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000"
                                                        class="form-control" step="0.01" value="{{ $stage->cost }}"
                                                        placeholder="Prezzo">
                                                @else
                                                    <input type="number" id="inputPrice" name="inputPrice[]" min="0" max="1000"
                                                        class="form-control" step="0.01" placeholder="Prezzo">
                                                @endif
                                                <label for="inputPrice">Prezzo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating">
                                        @if (isset($stage))
                                            <textarea name="textDescription" id="textDescription" style="height:auto"
                                                class="form-control"
                                                placeholder="Descrizione">{{ $stage->description }}</textarea>
                                        @else
                                            <textarea name="textDescription[]" id="textDescription" rows="4"
                                                class="form-control" placeholder="Descrizione"></textarea>
                                        @endif
                                        <label for="textDescription">Descrizione</label>
                                    </div>
                                </div>
                                @if(!isset($stage))
                                    <div class="text-end p-1">
                                        <button type="button" class="btn btn-sm btn-danger removeStageBtn d-none">
                                            <i class="bi bi-trash"></i> Rimuovi tappa
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if(!isset($stage))
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 col-8">
                    <button class="btn btn-primary w-100" id="addStage">
                        <i class="bi bi-plus"></i> Altra tappa
                    </button>
                </div>
            </div>
        @endif
@endsection