<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome to Central Invoice System')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- JS -->
    <script src="{{ asset('js/script.js') }}" defer></script>
  
</head>
<body>

    @include('partials.topbar')

        @yield('content')
   
    @include('partials.footer')

</body>
</html>
