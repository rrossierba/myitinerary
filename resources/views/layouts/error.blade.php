@extends('layouts.master')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">@lang('nav.home')</li>
<li class="breadcrumb-item active" aria-current="page">@lang('nav.error') @yield('title')</li>
@endsection

@section('body')
    <div class="row mt-5">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
            <div class="card text-center">
                <div class="card-header">
                    <h2 class="text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                        @yield('error_title')
                    </h2>
                </div>
                <div class="card-body">
                    <p class="mb-3 text-muted">
                    @yield('error_general_message')
                    </p>
                    @yield('image')
                    @if (isset($message))
                        <p class="text-danger fw-semibold">{{ $message }}</p>
                    @endif
                </div>
                <div class="card-footer bg-error">
                    @yield('error_footer')
                    <a href="{{ route('home') }}" class="btn btn-outline-danger">
                        <i class="bi bi-house"></i> @lang('errors.back_home')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection