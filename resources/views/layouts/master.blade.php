<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <title>MyItinerary - @yield('title')</title>

    <!-- Style sheets -->
    <link rel="stylesheet" href="{{ url('/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
    @yield('styles')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/bootstrap/js/bootstrap.min.js"></script>
    @yield('scripts')
</head>

<body>
    <div class="bg-white border-bottom fixed-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="/img/logo.svg" alt="Logo" width="30" height="24" class="me-2">
                    MyItinerary
                </a>

                <!-- Menu -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item ms-1">
                            <a class="ps-1 nav-link" aria-current="page"
                                href="{{ route('home') }}">@lang('nav.home')</a>
                        </li>
                        <li class="nav-item ms-1">
                            <a class="ps-1 nav-link" aria-current="page"
                                href="{{ route('search') }}">@lang(key: 'nav.search_itinerary')</a>
                        </li>
                        @if (auth()->check())
                            @if (auth()->user()->role == 'registered_user')
                                <li class="nav-item dropdown ms-1">
                                    <a class="ps-1 nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        @lang('nav.manage_itineraries')
                                    </a>
                                    <ul class="dropdown-menu mb-2">
                                        <li><a class="dropdown-item"
                                                href="{{ route('itinerary.index') }}">@lang('nav.my_itineraries')</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('itinerary.create') }}">@lang('nav.create_itinerary')</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item ms-1">
                                    <a class="ps-1 nav-link" aria-current="page"
                                        href="{{ route('favourites.index') }}">@lang('nav.saved_itineraries')</a>
                                </li>
                            @else
                                <li class="nav-item dropdown ms-1">
                                    <a class="ps-1 nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        @lang('nav.admin')
                                    </a>
                                    <ul class="dropdown-menu mb-2">
                                        <li><a class="dropdown-item"
                                                href="{{ route('city.index') }}">@lang('nav.manage_cities')</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                    </ul>

                    <!-- Sezione login -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown ms-1 ">

                            <a class="ps-1 nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @lang('nav.languages')
                            </a>
                            @if(isset($login))
                                <ul class="dropdown-menu mb-2 dropdown-menu-end">
                            @else
                                    <ul class="dropdown-menu mb-2">
                                @endif
                                    <li><a class="dropdown-item"
                                            href="{{ route('language.set', ['language' => 'en']) }}">🇺🇸
                                            English</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('language.set', ['language' => 'it']) }}">🇮🇹
                                            Italiano</a>
                                    </li>
                                </ul>
                        </li>
                        @if (auth()->check())
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                    {{ auth()->user()->name }}
                                    @if (auth()->user()->role === 'admin')
                                        (@lang('nav.administrator'))
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <label for="logoutSubmit" class="btn nav-link w-100 logout"><i
                                                class="bi bi-box-arrow-left"></i>
                                            @lang('nav.logout')</label>
                                    </li>
                                </ul>

                                <form action="{{ route('logout') }}" method="post" class="ms-2">
                                    @csrf
                                    <input type="submit" class="d-none" id="logoutSubmit">
                                </form>
                            </li>
                        @else
                            <li>
                                @if(!isset($login))
                                    <a href="{{route('login')}}" class="btn btn-outline-secondary m-e2"><i
                                            class="bi bi-person-circle"></i>
                                        @lang('nav.login')</a>
                                    <!-- <a href="{{route('register')}}" class="btn btn-outline-secondary"><i class="bi bi-person-circle"></i>
                                                @lang('nav.register')</a> -->
                                @endif
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
            aria-label="breadcrumb">
            <ol class="breadcrumb ps-3">
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>

    <div class="container" style="margin-top: 110px;">

        <!-- titolo -->
        <div class="row">
            <h1 class="text-center">
                @yield('title')
            </h1>
        </div>

        <!-- body -->
        <div class="container mb-5">
            @yield('body')
        </div>

    </div>

</body>

</html>