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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/d6f1131e8e.js" crossorigin="anonymous"></script>
</head>
<body class="login-bg">
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-3 custom-login-form">
                        <div class="mb-5">
                            <img src="{{ asset('images/icare-logo.jpg') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="200px" width="200px">
                        </div>
                        <div class="card">
                            <div class="card-header fw-semibold text-center fs-5">Page not found</div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between my-2">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Go Back</a>
                                    <span class="text-secondary fst-italic mt-1">or</span>
                                    <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>

