@extends('layouts.master')

@section('title', 'Home Page')

@section('breadcrumb')
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('body')
    <div class="row">
        <p>
            Benvenuto in MyItinerary, l'applicazione per gestire gli itinerari dei tuoi viaggi e per scoprire nuovi
            itinerari. <br>
            Scopri ora cosa puoi fare!
        </p>
        <p>
            Crea gli itinerari dei tuoi viaggi con le loro foto. Condividili o conservali per te!
        </p>
    </div>

    <!-- option cards -->
    <div class="row g-4">
        @foreach ($features as $feature)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card mx-auto home-card" style="width: 90%;">
                    <a class="link-underline-opacity-0 link-dark" href="{{ route($feature->getRoute()) }}">
                        <img src="img/{{ $feature->getImgName() }}" class="card-img-top" alt="...">
                        <div class="card-body d-flex justify-content-center">
                            <h4 class="card-text">{{ $feature->getName() }}</h4>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection