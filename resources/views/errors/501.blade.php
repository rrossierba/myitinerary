@extends('layouts.master') <!-- title - active_home - active_MyLibrary - breadcrumb - body -->

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Not implemented</li>
@endsection

@section('body')

<div class="container-fluid text-center">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-danger">
                <div class='card-header'>
                    <b>Not implemented:</b> this functionality has not been implemented yet
                </div>
                <div class='card-body'>
                    <p><img class="img-thumbnail" src="{{ url('/') }}/img/comingSoon.png"></p>
                    <p><a class="btn btn-danger" href="{{ url()->previous() }}"><i class="bi bi-box-arrow-left"></i> Go Back!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection