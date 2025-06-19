@extends('layouts.master')

@section('title')
    @lang('nav.home_page')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">@lang('nav.home')</li>
@endsection

@section('body')
    <div class="hero-content">
        <p class="lead">@lang('nav.welcome_message')</p>
        <p class="fs-5">@lang('nav.welcome_subtitle')</p>
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
                            <h4>@lang('nav.search_itinerary')</h4>
                            <p>@lang('nav.search_home_message')</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-2 p-2">
                        <a href="{{ route('itinerary.create') }}" class="link-underline link-underline-opacity-0 link-dark">
                            <div class="feature-icon">
                                <i class="bi bi-map"></i>
                            </div>
                            <h4>@lang('nav.create_itinerary')</h4>
                            <p>@lang('nav.create_home_message')</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-2 p-2">
                        <a href="{{ route('itinerary.index') }}" class="link-underline link-underline-opacity-0 link-dark">
                            <div class="feature-icon">
                                <i class="bi bi-share"></i>
                            </div>
                            <h4>@lang('nav.home_share')</h4>
                            <p>@lang('nav.share_home_message')</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection