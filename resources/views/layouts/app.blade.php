<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &ndash; {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css?123') }}" rel="stylesheet">

    @yield('header')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('/images/logo-v1-large.png') }}" width="140" height="auto" alt="{{ config('app.name', 'Laravel') }}" />
                </a>
                <ul class="nav nav-pills float-right">
                    <li class="nav-item d-none d-sm-inline">
                        <a href="{{ url('/') }}" class="nav-link">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url(route('charts.index')) }}" class="nav-link">
                            <i class="fa fa-bar-chart"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="container mt-2 py-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('/images/logo-v1-large.png') }}" width="110" height="auto" alt="{{ config('app.name', 'Laravel') }}" />
                    </a>
                    <small class="d-block mt-3 mb-5 text-muted">&copy; Family Media LLC</small>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Resource</a></li>
                        <li><a class="text-muted" href="#">Resource name</a></li>
                        <li><a class="text-muted" href="#">Another resource</a></li>
                        <li><a class="text-muted" href="#">Final resource</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Resource</a></li>
                        <li><a class="text-muted" href="#">Resource name</a></li>
                        <li><a class="text-muted" href="#">Another resource</a></li>
                        <li><a class="text-muted" href="#">Final resource</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Resource</a></li>
                        <li><a class="text-muted" href="#">Resource name</a></li>
                        <li><a class="text-muted" href="#">Another resource</a></li>
                        <li><a class="text-muted" href="#">Final resource</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Resource</a></li>
                        <li><a class="text-muted" href="#">Resource name</a></li>
                        <li><a class="text-muted" href="#">Another resource</a></li>
                        <li><a class="text-muted" href="#">Final resource</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
