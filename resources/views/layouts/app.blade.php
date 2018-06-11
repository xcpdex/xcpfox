<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page Meta -->
    <title>@yield('title') &ndash; {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="@yield('description')">
    <link rel="canonical" href="@yield('canonical')">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

@yield('header')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url(route('home')) }}">
                    <img src="{{ asset('/images/logo-v1-large.png') }}" width="140" height="auto" alt="{{ config('app.name', 'Laravel') }}" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item d-none d-lg-inline">
                            <a href="{{ url(route('home')) }}" class="nav-link">
                                <i class="fa fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url(route('assets.index')) }}" class="nav-link">
                                <i class="fa fa-list-ul"></i>
                                Assets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url(route('blocks.index')) }}" class="nav-link">
                                <i class="fa fa-cubes"></i>
                                Blocks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url(route('charts.index')) }}" class="nav-link">
                                <i class="fa fa-bar-chart"></i>
                                Charts
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i> More
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url(route('transactions.index')) }}">Transactions</a>
                                <a class="dropdown-item" href="{{ url(route('leaderboard.index')) }}">Leaderboard</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url(route('faq')) }}">What is XCP?</a>
                                @if (Auth::check())
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                  onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                      <i class="fa fa-power-off"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                @endif
                            </div>
                        </li>
                        <li class="nav-item d-inline d-lg-none">
                            <a href="{{ url(route('search.index')) }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                Search
                            </a>
                        </li>
                    </ul>
                    <form method="GET" action="{{ url(route('search.index')) }}" class="form-inline d-none d-lg-inline">
                        <input name="q" class="form-control mr-sm-2" type="search" placeholder="Address / Asset / Tx Hash" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="container mt-1 py-5 border-top">
            <div class="row">
                <div class="col-6 col-md">
                    <h5>Community</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="https://github.com/CounterpartyXCP">GitHub</a></li>
                        <li><a class="text-muted" href="#">Newsletter</a></li>
                        <li><a class="text-muted" href="#">Events</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="{{ url(route('docs')) }}">API Docs</a></li>
                        <li><a class="text-muted" href="{{ url(route('faq')) }}">FAQ</a></li>
                        <li><a class="text-muted" href="#">Support</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Legal</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="{{ url(route('terms')) }}">Terms of Service</a></li>
                        <li><a class="text-muted" href="{{ url(route('privacy')) }}">Privacy Policy</a></li>
                        <li><a class="text-muted" href="{{ url(route('disclaimer')) }}">Disclaimer</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>About Us</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Our Team</a></li>
                        <li><a class="text-muted" href="#">Contact</a></li>
                        <li><a href="https://t.me/xcpfox"><i class="fa fa-telegram"></i></a> <a class="text-muted" href="https://t.me/xcpfox">Telegram</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md">
                    <a href="{{ url(route('home')) }}" class="d-none d-md-inline-block">
                        <img src="{{ asset('/images/logo-v1-large.png') }}" width="140" height="auto" alt="{{ config('app.name', 'Laravel') }}" />
                    </a>
                    <small class="d-block mt-3 text-muted">&copy; 2018 Family Media LLC</small>
                </div>
            </div>
        </footer>
    </div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>