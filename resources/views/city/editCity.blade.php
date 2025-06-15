@extends('layouts.master')

@section('title')
    @if (isset($city))
        Modifica Città
    @else
        Aggiungi Città
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">Città</li>
    @if (isset($city))
        <li class="breadcrumb-item active">Modifica Città</li>
    @else
        <li class="breadcrumb-item active">Aggiungi Città</li>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var fields = [
                {
                    input: $('input[name=inputState]'),
                    errorId: '#invalidState',
                    errorMessage: 'Lo stato è obbligatorio'
                },
                {
                    input: $('input[name=inputRegion]'),
                    errorId: '#invalidRegion',
                    errorMessage: 'La regione è obbligatoria'
                },
                {
                    input: $('input[name=inputName]'),
                    errorId: '#invalidName',
                    errorMessage: 'Il nome è obbligatorio'
                }
            ];

            @if (isset($city))
                var initialValues = fields.map((field) => field.input.val());
                fields.forEach((field, index) => {
                    field.input.on('input', function () {
                        let changed = false;
                        for (let i = 0; i < fields.length; i++) {
                            if (fields[i].input.val().trim() !== initialValues[i]) {
                                changed = true;
                                break;
                            }
                        }
                        $('#submitButton').toggle(changed);
                    });
                });
            @endif

            $("form[name='city'").submit(function (event) {
                event.preventDefault();

                var error = false;
                for (var i = 0; i < fields.length; i++) {
                    var field = fields[i];
                    var inputValue = field.input.val();
                    if (!error && inputValue.trim() === "") {
                        error = true;
                        $(field.errorId).text(field.errorMessage);
                        field.input.addClass('invalidFocus');
                        field.input.focus();
                    } else {
                        field.input.removeClass('invalidFocus');
                        $(field.errorId).empty();
                    }
                }
                if (!error) {
                    $.ajax({
                        url: '{{ route('api.city.exist') }}',
                        async: true,
                        data: {
                            state: $('input[name=inputState]').val(),
                            region: $('input[name=inputRegion]').val(),
                            name: $('input[name=inputName]').val()
                        },
                        success: function (data) {
                            if (data.exist) {
                                $('#errorModal .modal-body').html('Città già esistente');
                                var modal = new bootstrap.Modal(document.getElementById('errorModal'));
                                modal.show();
                            } else
                                $("form[name='city'")[0].submit();
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

    @if (isset($city))
        <form name="city" method="post" action="{{ route('city.update', ['city' => $city->id]) }}">
            @method('PUT')
    @else
            <form name="city" method="post" action="{{ route('city.store') }}">
        @endif
            @csrf
            <div class="row justify-content-end mb-2">
                <div class="col-lg-2 col-md-4 col-6">
                    <input type="submit" class="d-none" id="editSubmit">
                    @if (isset($city))
                        <label for="editSubmit" class="btn btn-success w-100" id="submitButton" style="display: none"><i
                                class="bi bi-floppy"></i> Modifica</label>
                    @else
                        <label for="editSubmit" class="btn btn-success w-100"><i class="bi bi-pencil" id="submitButton"></i>
                            Salva</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <a href="{{ url()->previous() }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i> Annulla</a>
                </div>
            </div>

            <!-- stato -->
            <div class="row mb-3">
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <label for="inputState" class="col-form-label">Inserisci stato</label>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-12">
                    @if (isset($city))
                        <input type="text" id="inputState" name="inputState" value="{{ $city->state }}" class="form-control">
                    @else
                        <input type="text" id="inputState" name="inputState" placeholder="Stato" class="form-control">
                    @endif
                    <span class="invalidInput" id="invalidState"></span>
                </div>
            </div>

            <!-- regione -->
            <div class="row mb-3">
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <label for="inputRegion" class="col-form-label">Inserisci regione</label>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-12">
                    @if (isset($city))
                        <input type="text" id="inputRegion" name="inputRegion" value="{{ $city->region }}" class="form-control">
                    @else
                        <input type="text" id="inputRegion" name="inputRegion" placeholder="Regione" class="form-control">
                    @endif
                    <span class="invalidInput" id="invalidRegion"></span>
                </div>
            </div>

            <!-- nome -->
            <div class="row mb-3">
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <label for="inputName" class="col-form-label">Inserisci nome</label>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-12">
                    @if (isset($city))
                        <input type="text" id="inputName" name="inputName" value="{{ $city->name }}" class="form-control">
                    @else
                        <input type="text" id="inputName" name="inputName" placeholder="Nome" class="form-control">
                    @endif
                    <span class="invalidInput" id="invalidName"></span>
                </div>
            </div>
        </form>


@endsection