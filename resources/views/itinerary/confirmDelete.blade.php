@extends('layouts.master')

@section('title', 'Elimina itinerario')

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.manage_itineraries')</li>
    <li class="breadcrumb-item">@lang('nav.my_itineraries')</li>
    <li class="breadcrumb-item active">@lang('nav.delete_itinerary')</li>
@endsection

@section('body')

    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-12">
                <header>
                    <h2>
                        @lang('itinerary.delete_message') "{{ $itinerary->title }}"
                    </h2>
                </header>
                <p class="confirm">
                    @lang('itinerary.delete_confirm_message')
                </p>
            </div>
        </div>
        <div class="row">
            <form name="itinerary.delete" method="post"
                action="{{ route('itinerary.destroy', ['itinerary' => $itinerary]) }}">
                @method('DELETE')
                @csrf
                <input id="mySubmit" class="d-none" type="submit" value="Delete">
            </form>
            <div class="col-6">
                <a class="btn btn-secondary w-100" href="{{ url()->previous() }}"><i class="bi bi-box-arrow-left"></i>
                @lang('itinerary.cancel')</a>
            </div>
            <div class="col-6">
                <label for="mySubmit" class="btn btn-danger w-100"><i class="bi bi-trash"></i> @lang('itinerary.delete')</label>
            </div>
        </div>
    </div>

@endsection