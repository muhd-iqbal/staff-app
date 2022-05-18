<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.nav-agent')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @if (session()->has('success'))
    <div id="flash" class="absolute z-50 top-0 left-0 right-0 bg-green-500 text-center leading-10 overflow-hidden shadow-md">
        {!! session('success') !!}
    </div>
    @endif
    @if (session()->has('forbidden'))
    <div id="flash" class="absolute z-50 top-0 left-0 right-0 bg-red-500 text-center leading-10 overflow-hidden shadow-md">
        <p>{!! session('forbidden') !!}</p>
    </div>
    @endif
    @if (session()->has('success') || session()->has('forbidden'))
        <script>
            setTimeout(function() {
                document.getElementById('flash').style.display = 'none';
            }, 2500);
        </script>
    @endif
    <script src="https://kit.fontawesome.com/69c637cb03.js" crossorigin="anonymous"></script>
</body>

</html>
