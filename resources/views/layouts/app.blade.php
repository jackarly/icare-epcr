<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-3ea8b221.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('build/assets/app-d4b42df8.js') }}"></script>
    <script src="https://kit.fontawesome.com/d6f1131e8e.js" crossorigin="anonymous"></script>
</head>
<body class="">
    <div id="app">

        <!-- Navbar -->
        @include('inc.navbar')
        <main class="py-4">

            <!-- Errors and messages -->
            @include('inc.messages')
            
            <!-- Main page and content -->
            @yield('content')
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
