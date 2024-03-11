<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('pittogramma.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pagina Non Disponibile</title>

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body class="not-found-page">
    <div id="app">

        <header class="py-1 d-flex shadow justify-content-center ms_bg-yellow align-items-center">
                <img src="{{ Vite::asset('resources\img\logotipo.png') }}" alt="Logo Devvery">
        </header>

        <main class="container-fluid d-flex flex-column align-items-center justify-content-center ">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                
                <div class="d-flex flex-column align-items-center mb-5">
                    <img class="w-75" src="{{ Vite::asset('resources\img\404-img2.png') }}" alt="">
                    <a class="btn btn-warning fw-bold p-4" href="{{ URL::previous() }}">TORNA ALLA DASHBOARD</a>
                </div>
                <img class="w-50 object-fit-cover" src="{{ Vite::asset('resources\img\404-img.png') }}" alt="">
            </div>
            <h1 class="ms_badge-dark p-5 text-center">OOPS, SEMBRA CHE LA PAGINA RICHIESTA NON SI TROVI IN QUESTA PENTOLA !!!</h1>
        </main>

    </div>
</body>

</html>
