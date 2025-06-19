@extends('layouts.show')

@section('title')
    @lang('nav.results_for') "{{ $query }}"
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.search_itinerary')</li>
    <li class="breadcrumb-item active">'{{ $query }}'</li>
@endsection