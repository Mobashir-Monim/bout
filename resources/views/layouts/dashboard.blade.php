<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard-style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            
            <span class="navbar-brand col-md-3 col-lg-2 mr-0 px-3">
                <i class="fas fa-list text-white pr-3 d-md-none" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"></i>
                <i class="fas fa-list ml-5 text-white pr-3 d-none d-md-inline-block" type="button" onclick="toggleSideNav()"></i>
                <a class="text-white d-md-none" href="{{ route('home') }}">Bout</a>
                <a class="text-white d-none d-md-inline-block" href="{{ route('home') }}">Bout</a>
            </span>
            
            <ul class="navbar-nav pr-5 py-1 d-none d-md-block">
                <li class="nav-item float-right mx-2">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-primary nav-link px-3"><i class="fas fa-power-off text-white"></i> Logout</button>
                    </form>
                </li>
                {{-- <li class="nav-item float-right mx-2">
                    <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                </li> --}}
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @include('layouts.nav.index')
                <main role="main" class="col-md-9 col-lg-10 ml-sm-auto {{ startsWith(request()->url(), route('faculty-info')) ? 'p-0' : 'px-md-4 pt-4' }}" id="main">
                    <div class="{{ startsWith(request()->url(), route('faculty-info')) ? 'container-fluid p-0' : 'container' }}">
                        <div class="row">
                            <div class="col-md-12" id="flash-zone">
                                @include('flash::message')
                            </div>
                        </div>
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    @yield('scripts')
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        let sideNav = document.getElementById('sidebarMenu');
        let mainDisplay = document.getElementById('main');

        const toggleSideNav = () => {
            if (!sideNav.classList.contains('d-none')) {
                sideNav.classList.remove('col-md-3', 'col-lg-2', 'd-md-block');
                sideNav.classList.add('d-none');
                mainDisplay.classList.remove('col-md-9', 'col-lg-10');
                mainDisplay.classList.add('col-md-12', 'col-lg-12');
            } else {
                sideNav.classList.add('col-md-3', 'col-lg-2', 'd-md-block');
                sideNav.classList.remove('d-none');
                mainDisplay.classList.add('col-md-9', 'col-lg-10');
                mainDisplay.classList.remove('col-md-12', 'col-lg-12');
            }
        }
    </script>
    
    <!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>