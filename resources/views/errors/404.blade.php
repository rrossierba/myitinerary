@extends('layouts.master')

@section('title', '404 - Pagina Non Trovata')

@section('body')
<div class="text-center mt-5">
        <p>La pagina che cerchi non esiste o è stata rimossa.</p>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Torna alla Home</a>
    </div>
@endsection