@extends('layouts.master')

@section('title', 'Ricerca Itinerario')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Cerca itinerario</li>
@endsection

@section('body')
    <!-- form di ricerca -->
    <div class="mt-3 mb-3">
        <form action="{{ route('itinerary.search.results') }}" method="GET">

            <!-- filtri sulla ricerca (radio buttons) -->
            <div class=" mb-3 gap-3" id="radioForm">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-1 justify-content-center d-flex">
                        <label for="radioForm">Opzioni:</label>
                    </div>
                    @foreach ($filters as $filter)
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                            @if($loop->first)
                                <input type="radio" name="filter" value="{{ $filter->getValue() }}"
                                    id="option_{{ $filter->getValue() }}" class="btn-check" checked>
                            @else
                                <input type="radio" name="filter" value="{{ $filter->getValue() }}"
                                    id="option_{{ $filter->getValue() }}" class="btn-check">
                            @endif
                            <label class="btn btn-light rounded-pill border-dark w-100"
                                for="option_{{ $filter->getValue() }}">{{ $filter->getName() }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- ricerca testuale -->
            <div class="row">
                <!-- casella di ricerca -->
                <div class="input-group d-flex rounded-pill border border-dark p-2 search-form" id="search-itinerary-test">
                    <input type="text" name="query" class="form-control border-0 bg-transparent search-box"
                        placeholder="Cerca" autocomplete="off">
                    <input type="submit" id="searchSubmit" class="d-none">
                    <label for="searchSubmit" class="btn btn-success px-4 rounded-pill">
                        <i class="bi bi-search"></i>
                    </label>
                </div>
                
                <!-- recenti -->
                @if (sizeof($history)>0)
                <div class="suggestions">
                    <div class="recent-searches"><i class="bi bi-clock-history"></i> Ricerche recenti</div>
                    <div class="list-group">
                        @foreach ($history as $recent)
                        <div class="list-group-item list-group-item-action">{{ $recent->query_string}} | {{ $recent->group}}</div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </form>
    </div>
@endsection