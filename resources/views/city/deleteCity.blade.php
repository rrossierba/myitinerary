@extends('layouts.master')

@section('title', 'Elimina Città')

@section('breadcrumb')
<li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.admin')</li>
    <li class="breadcrumb-item">@lang('nav.city')</li>
    <li class="breadcrumb-item active">@lang('nav.delete_city')</li>
@endsection

@section('body')

    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-12">
                <header>
                    <h2>
                        @lang('city.delete_message') "{{ $city->name }}"
                    </h2>
                </header>
                <p class="confirm">
                    @lang('city.delete_confirm_message')
                </p>
            </div>
        </div>
        <div class="row">
            <form name="city.delete" method="post"
                action="{{ route('city.destroy', ['city' => $city]) }}">
                @method('DELETE')
                @csrf
                <input id="mySubmit" class="d-none" type="submit" value="Delete">
            </form>
            <div class="col-6">
                <a class="btn btn-secondary w-100" href="{{ url()->previous() }}"><i class="bi bi-box-arrow-left"></i>
                    @lang('city.cancel')</a>
            </div>
            <div class="col-6">
                <label for="mySubmit" class="btn btn-danger w-100"><i class="bi bi-trash"></i> @lang('city.delete')</label>
            </div>
        </div>
    </div>

@endsection