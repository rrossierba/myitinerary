@extends('layouts.master')

@section('title')
    @if (isset($itinerary))
        @lang('nav.edit_itinerary')
    @else
    @lang('nav.create_itinerary')
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.manage_itineraries')</li>
    @if (isset($itinerary))
        <li class="breadcrumb-item active">@lang('nav.edit_itinerary')</li>
    @else
        <li class="breadcrumb-item active">@lang('nav.create_itinerary')</li>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // visualizzazione dinamica bottone modifica
            @if (isset($itinerary))
                const fields = [
                    'input[name=inputTitle]',
                    'input[name=citySelector]',
                    'input[name=visibility]'
                ];

                // Leggi i valori iniziali correttamente
                const initialValues = fields.map((field) => {
                    const $el = $(field);
                    return $el.is(':checkbox') ? $el.prop('checked') : $el.val().trim();
                });

                fields.forEach((field, index) => {
                    const $el = $(field);
                    const eventType = $el.is(':checkbox') ? 'change' : 'input';

                    $el.on(eventType, function () {
                        let changed = false;

                        for (let i = 0; i < fields.length; i++) {
                            const $f = $(fields[i]);
                            const currentValue = $f.is(':checkbox') ? $f.prop('checked') : $f.val().trim();

                            if (currentValue !== initialValues[i]) {
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
                $('#invalidCity').hide();

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
                    $('#invalidTitle').text('@lang('itinerary.message_missing_title')');
                    $('#invalidTitle').show();
                    $('input[name=inputTitle]').addClass('is-invalid');
                    $('input[name=inputTitle]').focus();
                } else {
                    $('input[name=inputTitle]').removeClass('is-invalid');
                    $('#invalidTitle').empty();
                    $('#invalidTitle').hide()
                }

                // controllo su città
                if (!error && $('input[name=citySelector]').val().trim() === '') {
                    error = true;
                    $('#invalidCity').text('@lang('itinerary.message_missing_city')');
                    $('#invalidCity').show();
                    $('input[name=citySelector]').addClass('is-invalid');
                    $('input[name=citySelector]').focus();
                } else if (!error && !$('input[name=citySelector]').val().trim().match(/^(.+?) \((.+?), (.+?)\)$/)) {
                    error = true;
                    $('#invalidCity').text('@lang('itinerary.message_format_city')');
                    $('#invalidCity').show();
                    $('input[name=citySelector]').addClass('is-invalid');
                    $('input[name=citySelector]').focus();
                }
                else {
                    $('input[name=citySelector]').removeClass('is-invalid');
                    $('#invalidCity').empty();
                    $('#invalidCity').hide();
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
                                $('#errorModal .modal-body').html('@lang('itinerary.wrong_city_format') <br> @lang('itinerary.correct_city_form')');
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
                    <h5 class="modal-title" id="errorModalLabel">@lang('itinerary.error')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">@lang('itinerary.close')</button>
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
                                class="bi bi-floppy"></i> @lang('itinerary.save')</label>
                    @else
                        <label for="editSubmit" class="btn btn-success w-100"><i class="bi bi-pencil"></i>
                            @lang('itinerary.add_stages')</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    @if (isset($itinerary))
                        <a href="{{ route('itinerary.index') }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i>
                            @lang('itinerary.cancel')</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-danger w-100"><i class="bi bi-x-lg"></i>
                            @lang('itinerary.cancel')</a>
                    @endif
                </div>
            </div>

            <!-- titolo -->
            <div class="row">
                <div class="col-12">
                    <div class="form-floating">
                        @if (isset($itinerary))
                            <input type="text" id="inputTitle" name="inputTitle" value="{{ $itinerary->title }}"
                                class="form-control" placeholder="@lang('itinerary.title')">
                        @else
                            <input type="text" id="inputTitle" name="inputTitle" placeholder="@lang('itinerary.title')"
                                class="form-control">
                        @endif
                        <label for="inputTitle" class="col-form-label">@lang('itinerary.title')</label>
                        <div class="alert alert-danger" id="invalidTitle" style="display: none;"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- città -->
                <div class="col-12">
                    <div class="form-floating mt-1">
                        @if (isset($itinerary))
                            <input type="text" class="form-control w-100" autocomplete="off" name="citySelector"
                                placeholder="@lang('itinerary.city')" id="cityInput"
                                value="{{ $itinerary->city->name }} ({{ $itinerary->city->region }}, {{ $itinerary->city->state }})">
                        @else
                            <input type="text" class="form-control w-100" id="cityInput" autocomplete="off" name="citySelector"
                                placeholder="@lang('itinerary.city')">
                        @endif
                        <label for="inserCity" class="form-label">@lang('itinerary.city')</label>
                        <div class="alert alert-danger" id="invalidCity" style="display: none;"></div>
                    </div>
                    <ul id="citySuggestions" class="list-group position-absolute" style="z-index: 1000;"></ul>
                </div>
            </div>
            <!-- visibilità -->
            <div class="row">
                <div class="col-12">
                    <div class="form-floating">
                        @php
                            $selected = isset($itinerary) ? $itinerary->visibility->value : 'public';
                        @endphp

                        <div class="form-floating mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="visibilityCheckbox" name="visibility"
                                    value="private" {{ $selected === 'private' ? 'checked' : '' }}>
                                <label class="form-check-label" for="visibilityCheckbox">
                                    @if(isset($itinerary))
                                        @lang('itinerary.private')
                                    @else
                                        @lang('itinerary.private_create')
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>

        @if (isset($itinerary->stages))
            @if ($itinerary->stages->count() > 0)
                <h3>@lang('itinerary.edit_stages')</h3>
                <ul class="list-group">
                    @foreach ($itinerary->stages as $stage)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-4 col-6">
                                    {{ $stage->location }}
                                </div>
                                <div class="col-lg-2 d-lg-block d-none">
                                    @lang('itinerary.price'): {{ $stage->cost }} €
                                </div>
                                <div class="col-lg-2 d-lg-block d-none">
                                @lang('itinerary.duration'): {{ $stage->duration }} @lang('itinerary.minutes')
                                </div>
                                <div class="col-lg-2 col-3">
                                    <a href="{{ route('stage.edit', ['stage' => $stage]) }}" class="btn btn-primary mb-2 w-100"><i
                                            class="bi bi-pencil"></i> @lang('itinerary.modify')</a>
                                </div>
                                <div class="col-lg-2 col-3">
                                    <a href="{{ route('stage.destroy.confirm', ['stage' => $stage]) }}"
                                        class="btn btn-danger mb-2 w-100"><i class="bi bi-trash"></i> @lang('itinerary.delete')</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <div class="row justify-content-center mt-2">
                <div class="col-6">
                    <a href="{{ route('stage.create', ['itinerary' => $itinerary]) }}" class="btn btn-primary w-100"><i
                            class="bi bi-plus"></i> @lang('itinerary.add_stages')</a>
                </div>
            </div>
        @endif
@endsection