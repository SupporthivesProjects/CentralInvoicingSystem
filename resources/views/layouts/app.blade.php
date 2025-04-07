<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome to Central Invoice System')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link id="style" href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Main Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons CSS -->
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">

    <!-- Waves CSS -->
    <link href="{{ asset('libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar CSS -->
    <link href="{{ asset('libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker CSS -->
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices CSS -->
    <link rel="stylesheet" href="{{ asset('libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- JSVectorMap CSS -->
    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">

    <!-- Toastr CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')
</head>

<body>
    @unless(in_array(Route::currentRouteName(), ['login', 'password.request', 'password.reset']))
        @include('partials.topbar')
    @endunless


    @yield('content')

    @include('partials.footer')

    <!-- jQuery (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Choices JS -->
    <script src="{{ asset('libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Your Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
