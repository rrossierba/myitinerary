@extends('layouts.master')

@section('title')
    @lang('nav.delete_stage')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.manage_itineraries')</li>
    <li class="breadcrumb-item active">@lang('nav.edit_itinerary')</li>
@endsection

@section('body')
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-12">
                <header>
                    <h2>
                        @lang('stage.delete_stage_message') "{{ $stage->location }}"
                    </h2>
                </header>
                <p class="confirm">
                @lang('stage.delete_stage_message_confirm')
                </p>
            </div>
        </div>
        <div class="row">
            <form name="stage.delete" method="post" action="{{ route('stage.destroy', ['stage' => $stage]) }}">
                @method('DELETE')
                @csrf
                <input id="mySubmit" class="d-none" type="submit" value="Delete">
            </form>
            <div class="col-6">
                <a class="btn btn-secondary w-100"
                    href="{{ route('itinerary.edit', ['itinerary' => $stage->itinerary]) }}"><i
                        class="bi bi-box-arrow-left"></i> @lang('stage.cancel')</a>
            </div>
            <div class="col-6">
                <label for="mySubmit" class="btn btn-danger w-100"><i class="bi bi-trash"></i> @lang('stage.delete')</label>
            </div>
        </div>
    </div>

@endsection