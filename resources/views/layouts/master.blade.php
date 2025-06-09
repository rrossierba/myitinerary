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

    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/bootstrap/js/bootstrap.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid text-center">

            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="/img/logo.svg" alt="Logo" width="30" height="24" class="me-2">
                MyItinerary
            </a>

            <!-- Menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item ms-1">
                        <a class="btn nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="btn nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Itinerari
                        </a>
                        <ul class="dropdown-menu mb-2">
                            <li><a class="dropdown-item" href="{{ route('itinerary.index') }}">Tutti gli Itinerari</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('itinerary.search') }}">Cerca Itinerario</a>
                            </li>
                        </ul>
                    </li>
                    @if (auth()->check())
                        <li class="nav-item dropdown">
                            <a class="btn nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                I miei itinerari
                            </a>
                            <ul class="dropdown-menu mb-2">
                                <li><a class="dropdown-item" href="{{ route('itinerary.create') }}">Crea Itinerario</a></li>
                                <li><a class="dropdown-item" href="{{ route('itinerary.user.created') }}">Creati da me</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('favourites.index') }}">Itinerari salvati</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <!-- Sezione login -->
                <ul class="navbar-nav">
                    @if (auth()->check())
                        <li class="nav-item dropdown">
                            <a class="btn btn-primary" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                Profilo
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-center">
                                <li><a class="dropdown-item p-2" href=""><i class="bi bi-person-gear"></i> Gestisci</a></li>
                                <li>
                                    <label for="logoutSubmit" class="dropdown-item p-2"><i class="bi bi-box-arrow-left"></i>
                                        Logout</label>
                                </li>
                            </ul>

                            <form action="{{ route('logout') }}" method="post" class="ms-2">
                                @csrf
                                <input type="submit" class="d-none" id="logoutSubmit">
                            </form>
                        </li>
                    @else
                        <li>
                            @if(isset($login) && $login == true)
                                <a href="{{route('register')}}" class="btn btn-success"><i class="bi bi-person-circle"></i>
                                    Register</a>
                            @elseif(isset($register) && $register == true)
                                <a href="{{route('login')}}" class="btn btn-primary m-e2"><i class="bi bi-person-circle"></i>
                                    Login</a>
                            @else
                                <a href="{{route('login')}}" class="btn btn-primary m-e2"><i class="bi bi-person-circle"></i>
                                    Login</a>
                                <a href="{{route('register')}}" class="btn btn-success"><i class="bi bi-person-circle"></i>
                                    Register</a>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
        
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb ps-3 pb-3 border-bottom">
            @yield('breadcrumb')
        </ol>
    </nav>

    <div class="container mb-2 mt-2">
        <div class="row">
            <h1>
                @yield('title')
            </h1>
        </div>
    </div>

    <!-- body -->
    <div class="container mb-5">
        @yield('body')
    </div>

    <!-- footer -->
    <!-- <div class="container-fluid border-top bg-white mt-5 fixed-bottom">
        <footer class="d-flex flex-wrap py-3 justify-content-center">
            <span class="text-muted">&copy; Riccardo Rossi-Erba</span>
        </footer>
    </div> -->

</body>

</html>