@extends('layouts.master')

@section('title', 'Home Page')

@section('breadcrumb')
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('body')
    <div class="hero-content">
        <p class="lead">Benvenuto in MyItinerary, l'applicazione per gestire gli itinerari dei tuoi viaggi e per scoprire
            nuovi itinerari.</p>
        <p class="fs-5">Scopri ora cosa puoi fare!</p>
    </div>

    <section class="py-5 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="border rounded-2 p-2">
                        <a href="{{ route('search') }}" class="link-underline link-underline-opacity-0 link-dark">
                            <div class="feature-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <h4>Cerca itinerari</h4>
                            <p>Trova nuovi itinerari in base ai tuoi interessi</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-2 p-2">
                        <a href="{{ route('itinerary.create') }}" class="link-underline link-underline-opacity-0 link-dark">
                            <div class="feature-icon">
                                <i class="bi bi-map"></i>
                            </div>
                            <h4>Crea itinerari</h4>
                            <p>Crea gli itinerari di tuoi viaggi personalizzati</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-2 p-2">
                        <a href="{{ route('itinerary.index') }}" class="link-underline link-underline-opacity-0 link-dark">
                            <div class="feature-icon">
                                <i class="bi bi-share"></i>
                            </div>
                            <h4>Condividi e conserva</h4>
                            <p>Condividi foto e itinerari dei tuoi viaggi</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection