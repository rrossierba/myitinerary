@extends('layouts.master')

@section('title', 'Itinerari creati da me')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">I miei Itinerari</li>
    <li class="breadcrumb-item active">Creati da me</li>
@endsection

@section('body')

    @foreach ($itineraries as $itinerary)

    <div class="card mb-2 shadow-sm rounded p-3 mb-3">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-lg-10 col-8">
                        <h5 class="card-title">
                            <a href="{{ route('itinerary.show', ['itinerary' => $itinerary]) }}"
                                class="link-underline-opacity-0 link-dark">{{ $itinerary->title }}</a>
                        </h5>
                    </div>
                    <div class="col-lg-2 col-4">
                        <a href="{{ route('itinerary.edit',['itinerary'=>$itinerary]) }}" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-lg-10 col-8">
                        <div class="badge bg-secondary fs-6 mb-2">
                            <i class="bi bi-globe-europe-africa"></i>
                            {{ $itinerary->city->name }}
                        </div>
                        <div class="badge bg-primary fs-6 mb-2">
                            <i class="bi bi-currency-euro"></i>
                            {{ number_format($itinerary->price, 2, ',', '.') }}
                        </div>
                        <div class="badge bg-success fs-6 mb-2">
                            <i class="bi bi-person-fill"></i>
                            {{ $itinerary->user->name }}
                        </div>
                        <div class="badge bg-light fs-6 mb-2 text-dark">
                            <i class="bi bi-eye"></i>
                            {{ $itinerary->visibility }}
                        </div>
                    </div>

                    <div class="col-lg-2 col-4">
                        <div class="badge bg-danger fs-6 mb-2 w-100">
                            <i class="bi bi-heart-fill"></i>
                            {{ $itinerary->favourites->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection