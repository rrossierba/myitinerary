@extends('layouts.master')

@section('title', 'Ricerca Itinerario')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Cerca itinerario</li>
@endsection

@section('body')
    <!-- form di ricerca -->
    <div class="mt-3 mb-3">
        <!-- <form action="" method="GET"> -->

            <!-- filtri sulla ricerca (radio buttons) -->
            <div class="row justify-content-center">
                <!-- <div class="mb-3 gap-3 col-3" id="radioForm">
                        <div class="d-flex align-items-center">
                            <label for="radioForm" class="m-1 p-1">Opzioni:</label>
                            @foreach ($filters as $filter)
                                @if($loop->first)
                                    <input type="radio" name="filter" value="{{ $filter->getValue() }}"
                                        id="option_{{ $filter->getValue() }}" class="btn-check" checked>
                                @else
                                    <input type="radio" name="filter" value="{{ $filter->getValue() }}"
                                        id="option_{{ $filter->getValue() }}" class="btn-check">
                                @endif
                                <label class="btn btn-light rounded-pill w-100 m-1 p-1"
                                    for="option_{{ $filter->getValue() }}">{{ $filter->getName() }}</label>
                            @endforeach
                    </div>
                </div> -->
                <div class="col-9">
                    <!-- casella di ricerca -->
                    <div class="input-group d-flex rounded-pill border border-dark p-2 search-form"
                        id="search-itinerary-test">
                        <input id="searchBox" type="text" name="query" class="form-control border-0 bg-transparent search-box"
                            placeholder="Cerca" autocomplete="off">
                        <button id="searchSubmit" class="btn btn-success px-4 rounded-pill">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <!-- recenti -->
                    @if (sizeof($history) > 0)
                        <div class="suggestions">
                            <div class="recent-searches"><i class="bi bi-clock-history"></i> Ricerche recenti</div>
                            <div class="list-group" id="recentSearches">
                                @foreach ($history as $recent)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between">
                                            <span class="clickable">{{ $recent->query_string}}ù</span>
                                            <span class="clickable"><i class="bi bi-x"></i></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

    </div>
@endsection