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

    <!-- Add this in your <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Add this before </body> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- if not already included -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Prism CSS -->
    <link rel="stylesheet" href="{{ asset('libs/prismjs/themes/prism-coy.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">



    @stack('styles')
</head>

<body>
    @unless(Route::is('login'))
        @include('partials.topbar')
    @endunless

    @include("partials.mainhead")
    @include("partials.switcher")
    @include("partials.loader")
    @include("partials.header")

    @include("partials.sidebar")
    @yield('content')

    @include('partials.footer')

    <!-- Scripts -->

    <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('js/datatables.js') }}"></script>

    <script src="{{ asset('libs/@popperjs/core/umd/popper.min.js') }}></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('libs/node-waves/waves.min.js') }}></script>

    <!-- Sticky JS -->
    <script src="{{ asset('js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}></script>
    <script src="{{ asset('js/simplebar.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('libs/@simonwep/pickr/pickr.es5.min.js') }}></script>



    <!-- Custom-Switcher JS -->
    <script src="{{ asset('js/custom-switcher.min.js') }}"></script>

    <!-- Prism JS -->
    <script src="{{ asset('libs/prismjs/prism.js') }}></script>
    <script src="{{ asset('js/prism-custom.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
