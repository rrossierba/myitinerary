@extends('layouts.show')

@section('title')
@if (isset($research))
Risultati per {{ $research->query_string }} | {{ $research->group }}
@else
Tutti gli itinerari
@endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Cerca itinerario</li>
    @if (isset($research))
    <li class="breadcrumb-item active">'{{ $research->query_string }}'</li>
    @else
    <li class="breadcrumb-item active">Tutti gli itinerari</li>
    @endif
@endsection

@section('before_results')
<a href="{{ route('itinerary.search') }}" class="btn btn-success rounded-pill p-2 m-2"><i class="bi bi-arrow-left"></i> Ritorna alla ricerca</a>
@endsection