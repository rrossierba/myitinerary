@extends('layouts.app')

@section('title', '500 - Errore Interno')

@section('body')
    <div class="text-center mt-5">
        <h1>500 - Errore del server</h1>
        <p>Qualcosa è andato storto. Riprova più tardi.</p>
        <a href="{{ route('home') }}" class="btn btn-danger">Home</a>
    </div>
@endsection