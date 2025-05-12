<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <title>MyItinerary - @yield('title')</title>

    <!-- Style sheets -->
    <link rel="stylesheet" href="{{ url('/') }}/bootstrap/css/bootstrap.min.css">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
        
    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bs-body-bg">
    <div class="container-fluid ">
        <img src="/img/plane-logo.svg" alt="Bootstrap" width="30" height="24">
        <a class="navbar-brand" href="{{ route('home') }}">MyItinerary</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center text-center mx-auto" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link " href="{{ route('itinerary') }}">Itinerary</a>
            <a class="nav-link" href="{{ route('home') }}">Create Itinerary</a>
            <a class="nav-link" href="{{ route('home') }}">All Itinerary</a>
        </div>
        </div>
    </div>
    </nav>

    <nav class="navbar-light bs-body-bg" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        @yield('breadcrumb')
    </ol>
    </nav>

    @yield('body')
    
</body>
</html>