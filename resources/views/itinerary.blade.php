@extends('layouts.master')

@section('title', 'Itinerario')

@section('breadcrumb')
<li class="breadcrumb-item">Home</li>
<li class="breadcrumb-item active">Itinerario</li>
@endsection

@section('body')

<div class="container mt-4 pt-5">
    <div class="row g-4">
        <!-- Contenuto sinistra -->
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                <h3 class="card-title">Giro delle piazze del centro di Brescia</h3>
                <p class="text-muted">Un piacevole itinerario a piedi tra le più belle piazze del centro storico.</p>

                <!-- tappe -->
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <strong>Piazza Vittoria</strong> — Costo: gratuito — Durata: 10 min<br>
                        <small>Commento: “Carina e ben tenuta”</small>
                    </li>
                    <li class="list-group-item">
                        <strong>Piazza Loggia</strong> — Costo: gratuito — Durata: 15 min
                    </li>
                    <li class="list-group-item">
                        <strong>Piazza Paolo VI</strong> — Costo: gratuito — Durata: 20 min
                    </li>
                </ul>
                </div>
            </div>
        </div>

        <!-- Contenuto destra -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Dettagli itinerario</h5>
                    <p><strong>Like:</strong> <span class="badge-custom badge rounded-pill">❤️ 28</span></p>
                    <p><strong>Creato da:</strong> viaggiatore89</p>
                    <p><strong>Visibilità:</strong> Pubblico</p>

                    <hr>
                    <a class="btn btn-success w-100 mb-2">Salva Itinerario</a>
                    <a class="btn btn-outline-primary w-100">Segui il Creatore</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection