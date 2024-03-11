<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('pittogramma.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <nav class="navbar navbar-expand navbar-light ms_bg-yellow shadow-sm">
            <div class="container">
                <a class="navbar-brand d-none d-sm-flex align-items-center w-25" href="http://localhost:4242/">
                    <img class="w-50" src="{{ Vite::asset('resources\img\logotipo.png') }}" alt="Logo Devvery">
                </a>
                <a class="navbar-brand d-sm-none d-flex align-items-center w-25" href="http://localhost:4242/">
                    <img class="w-50" src="{{ Vite::asset('resources\img\pittogramma.png') }}" alt="Logo Devvery">
                </a>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-dark"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('admin') }}">{{ __('Dashboard') }}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>

            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>
</body>

</html>
