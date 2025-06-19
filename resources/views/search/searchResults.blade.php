@extends('layouts.show')

@section('title')
    @if (isset($search))
        Risultati per "{{ $query }}"
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