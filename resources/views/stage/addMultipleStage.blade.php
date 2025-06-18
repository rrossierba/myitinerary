@extends('layouts.master')

@section('title', 'Aggiungi Tappe')

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#addStage').on('click', function () {
                let $lastStage = $('.stage-form').last();
                let $newStage = $lastStage.clone();
                $newStage.find('input, textarea').val('');
                $('#stageContainer').append($newStage);
                $newStage.find('.removeStageBtn').removeClass('d-none');
            });

            $(document).on('click', '.removeStageBtn', function () {
                $(this).closest('.stage-form').remove();
            });
        });
    </script>
@endsection

@section('body')
    <form action="{{ route('stage.store', ['itinerary'=>$itinerary]) }}" method="post" name="allStageForm">
        @csrf
        <div class="row mb-3">
            <div class="col-lg-2 offset-lg-6 col-3 offset-6">
                <input type="submit" name="submit" id="submitSave" class="d-none" value="save">
                <label for="submitSave" class="btn btn-success w-100"><i class="bi bi-floppy"></i> Salva</label>
            </div>
            <div class="col-lg-2 col-3">
                <a href="{{ url()->previous() }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
            </div>
        </div>

        <div id="stageContainer">
            <div class="stage-form mb-2 justify-content-center">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="inputLocation" name="inputLocation[]"
                                        placeholder="Luogo">
                                    <label for="inputLocation">Luogo</label>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="number" id="inputDuration" name="inputDuration[]" min="0"
                                                max="1000" class="form-control" placeholder="Durata (min)">
                                            <label for="inputDuration">Durata (min)</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="number" id="inputPrice" name="inputPrice[]" min="0" max="1000"
                                                class="form-control" step="0.01" placeholder="Prezzo">
                                            <label for="inputPrice">Prezzo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating">
                                    <textarea name="textDescription[]" id="textDescription" class="form-control h-100"
                                        placeholder="Descrizione"></textarea>
                                    <label for="textDescription">Descrizione</label>
                                </div>
                            </div>
                            <div class="text-end p-1">
                                <button type="button" class="btn btn-sm btn-danger removeStageBtn d-none">
                                    <i class="bi bi-trash"></i> Rimuovi tappa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row justify-content-center">
        <div class="col-3">
            <button class="btn btn-primary w-100" id="addStage">
                <i class="bi bi-plus"></i> Altra tappa
            </button>
        </div>
    </div>
@endsection