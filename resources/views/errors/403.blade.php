@extends('layouts.master')

@section('title', '403 - Accesso Negato')

@section('body')
    <div class="text-center mt-5">
        <p>Non hai i permessi per visualizzare questa pagina.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Torna Indietro</a>
    </div>
@endsection