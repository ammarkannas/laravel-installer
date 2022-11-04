<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Application CSRF-TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Application title --}}
    <title>Install - @yield('title', config('app.name', 'Forums'))</title>

    {{-- Google Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    {{-- Stylesheets & Scripts --}}
    @vite(['pkgs/installer/src/resources/sass/installer.scss'])

    <style>
        body {
            background-color: #f5f5fa;
        }
        .card {
            border-color: rgba(213,213,219,0.51) !important;
        }
    </style>
</head>
<body>
    <div id="installer">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark position-sticky sticky-top">
            <div class="container-fluid">
                {{-- Appliaction Brand --}}
                <a href="" class="navbar-brand fw-bold">
                    {{ __('Installing') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Left Side Of Navbar --}}
                    <ul class="navbar-nav me-auto"></ul>

                    {{-- Right Side Of Navbar --}}
                    <ul class="navbar-nav ms-auto"></ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
