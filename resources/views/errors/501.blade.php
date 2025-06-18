@extends('layouts.error')

@section('title', '501 - Non Implementato')

@section('error_title', 'Pagina non ancora implementata')

@section('image')
<img src="{{ url('/') }}/img/coming-soon.png" style="width:75%">
@endsection

@section('error_general_message', 'Funzionalità non ancora implementata')

@section('error_footer')
<a class="btn btn-outline-secondary" href="{{ url()->previous() }}"><i class="bi bi-box-arrow-left"></i> Torna indietro</a>
@endsection

