@extends('layouts.master')

@section('title', 'Home Page')

@section('breadcrumb')
<li class="breadcrumb-item active">Home</li>
@endsection

@section('body')
    <!-- inserire form per ricerca -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <form action="#" method="GET" class="search-form">
            <div class="d-flex flex-column flex-md-row align-items-stretch rounded-pill shadow border border-dark p-2">
                <div class="d-flex align-items-center flex-grow-1">
                    <span class="input-group-text bg-transparent border-0">
                        <img src="/img/search.svg" alt="search" width="20" height="20">
                    </span>
                    <input type="text" name="query" class="form-control border-0 bg-transparent" placeholder="Search itinerary">    
                </div>
                <button class="btn btn-success px-4 rounded-pill" type="submit">Ricerca</button>
            </div>
            </form>
        </div>
    </div>

    <div class="container mt-4">
    <h1 class="mb-4">Itinerari Pubblici</h1>

    <div class="mb-5">
        <h5>Giro a bs - <small>Brescia</small></h5>

        <ul class="list-group list-group-flush"> 
            <li class="list-group-item">
                <strong>Piazza Vittoria</strong> - 10 € - 30 min
                <br>
                <small class="text-muted">Bello</small>
            </li>
        </ul>
        <div class="mt-2">
            <span class="badge bg-success">👍 50 like</span>
        </div>
    </div>

    
@endsection