<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@if($_GET)
    <meta name="robots" content="noindex, follow">
@endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description')">
    <title>@yield('title')</title>
    <link href="@yield('canonical')" rel="canonical">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({
              google_ad_client: "ca-pub-3402018973108947",
              enable_page_level_ads: true
         });
    </script>
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
                        <li class="nav-item d-inline d-lg-none">
                            <a href="{{ url(route('search.index')) }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                Search
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i> More
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url(route('transactions.index')) }}">Transactions</a>
                                <a class="dropdown-item" href="{{ url(route('mempool.index')) }}">Unconfirmed TXs</a>
                                <a class="dropdown-item" href="{{ url(route('messages.index')) }}">DB Messages</a>
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
                        <li><a class="text-muted" href="https://github.com/CounterpartyXCP" target="_blank">GitHub</a></li>
                        <li><a class="text-muted" href="https://counterparty.io/news/" target="_blank">Newsletter</a></li>
                        <li><a class="text-muted" href="#">Events</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="{{ url(route('docs')) }}">API Docs</a></li>
                        <li><a class="text-muted" href="{{ url(route('faq')) }}">FAQ</a></li>
                        <li><a class="text-muted" href="{{ url(route('protocol')) }}">Protocol</a></li>
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
                        <li><a class="text-muted" href="{{ url(route('about')) }}">Our Team</a></li>
                        <li><a class="text-muted" href="{{ url(route('contact')) }}">Contact</a></li>
                        <li><a href="https://t.me/xcpfox" target="_blank"><i class="fa fa-telegram"></i></a> <a class="text-muted" href="https://t.me/xcpfox" target="_blank">Telegram</a></li>
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112477384-8"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-112477384-8');
    </script>
</body>
</html>