@extends('layouts.master')

@section ('title')
    @if(isset($stage))
        @lang('nav.edit_stage')
    @else
        @lang('nav.create_stage')
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.manage_itineraries')</li>
    @if (isset($stage))
        <li class="breadcrumb-item">{{ $stage->itinerary->title }}</li>
        <li class="breadcrumb-item active">@lang('nav.edit_stage')</li>
    @else
        <li class="breadcrumb-item">{{ $itinerary->title }}</li>
        <li class="breadcrumb-item active">@lang('nav.create_stage')</li>
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
                        if (isChanged())
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
                    if (confirm('@lang('stage.remove_stage_message')?'))
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
                                class="bi bi-floppy"></i> @lang('stage.modify')</label>
                    @else
                        <label for="stageSubmit" class="btn btn-success w-100"><i class="bi bi-floppy"></i>
                            @lang('stage.save')</label>
                    @endif
                </div>
                @if (isset($stage))
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary]) }}" class="btn btn-danger w-100"><i
                                class="bi bi-x-lg"></i> @lang('stage.cancel')</a>
                    </div>
                @elseif (isset($add))
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary]) }}" class="btn btn-danger w-100"><i
                                class="bi bi-x-lg"></i> @lang('stage.cancel')</a>
                    </div>
                @endif
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
                                                placeholder="@lang('stage.location')" value="{{ $stage->location }}" required>
                                        @else
                                            <input type="text" class="form-control" id="inputLocation" name="inputLocation[]"
                                                placeholder="@lang('stage.location')" required>
                                        @endif
                                        <label for="inputLocation">@lang('stage.location')</label>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                @if (isset($stage))
                                                    <input type="number" id="inputDuration" name="inputDuration" min="0"
                                                        max="1000" class="form-control" value="{{ $stage->duration }}"
                                                        placeholder="@lang('stage.duration') (@lang('stage.minutes'))">
                                                @else
                                                    <input type="number" id="inputDuration" name="inputDuration[]" min="0"
                                                        max="1000" class="form-control"
                                                        placeholder="@lang('stage.duration') (@lang('stage.minutes'))">
                                                @endif
                                                <label for="inputDuration">@lang('stage.duration')
                                                    (@lang('stage.minutes'))</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                @if (isset($stage))
                                                    <input type="number" id="inputPrice" name="inputPrice" min="0" max="1000"
                                                        class="form-control" step="0.01" value="{{ $stage->cost }}"
                                                        placeholder="@lang('stage.price')">
                                                @else
                                                    <input type="number" id="inputPrice" name="inputPrice[]" min="0" max="1000"
                                                        class="form-control" step="0.01" placeholder="@lang('stage.price')">
                                                @endif
                                                <label for="inputPrice">@lang('stage.price')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating">
                                        @if (isset($stage))
                                            <textarea name="textDescription" id="textDescription" style="height:auto"
                                                class="form-control"
                                                placeholder="@lang('stage.description')">{{ $stage->description }}</textarea>
                                        @else
                                            <textarea name="textDescription[]" id="textDescription" rows="4"
                                                class="form-control" placeholder="@lang('stage.description')"></textarea>
                                        @endif
                                        <label for="textDescription">@lang('stage.description')</label>
                                    </div>
                                </div>
                                @if(!isset($stage))
                                    <div class="text-end p-1">
                                        <button type="button" class="btn btn-sm btn-danger removeStageBtn d-none">
                                            <i class="bi bi-trash"></i> @lang('stage.remove_stage')
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
                        <i class="bi bi-plus"></i> @lang('stage.add_stage')
                    </button>
                </div>
            </div>
        @endif
@endsection