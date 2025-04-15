<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

 <head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Central Invoice System - A responsive and secure admin panel for managing invoices, users, and analytics.">
    <meta name="author" content="Central Invoice System Team">
    <meta name="keywords" content="invoice system, admin panel, user management, dashboard, analytics, billing, responsive admin, Laravel admin, central invoice system">

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

    <!-- Prism CSS -->
    <link rel="stylesheet" href="{{ asset('libs/prismjs/themes/prism-coy.min.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Choices JS -->
    <script src="{{ asset('libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Main Theme JS -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    

    <!-- Custom Toast Style -->
    <style>
        #toast-container > .toast {
            color: #fff;
            background-color: #333; /* dark background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        #toast-container > .toast-success {
            background-color: #51A351; /* green */
        }
        #toast-container > .toast-error {
            background-color: #BD362F; /* red */
        }
    </style>

    @stack('styles')
    </head>

 <body>
       <!-- Loader -->
       <div id="loader" >
            <img src="{{ asset('images/media/media-79.svg') }}" alt="">
        </div>
        <!-- Loader -->
    @unless(in_array(Route::currentRouteName(), ['login', 'password.request', 'password.reset']))
        @include('partials.sidebar')
    @endunless

    @yield('content')
        @include("partials/switcher")
         
        @unless(in_array(Route::currentRouteName(), ['login', 'password.request', 'password.reset']))
        @include("partials/header")
        @endunless
        
        @include('partials.footer')
    <!-- Scroll To Top -->
        <div class="scrollToTop">
            <span class="arrow"><i class="fe fe-arrow-up"></i></span>
        </div>
        <div id="responsive-overlay"></div>
     
        <!-- Popper JS -->
        <script src="{{ asset('libs/@popperjs/core/umd/popper.min.js') }}"></script>

        <!-- Bootstrap JS -->
        <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Defaultmenu JS -->
        <script src="{{ asset('js/defaultmenu.min.js') }}"></script>

        <!-- Node Waves JS-->
        <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

        <!-- Sticky JS -->
        <script src="{{ asset('js/sticky.js') }}"></script>

        <!-- Simplebar JS -->
        <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('js/simplebar.js') }}"></script>

        <!-- Color Picker JS -->
        <script src="{{ asset('libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

        <!-- Custom-Switcher JS -->
        <script src="{{ asset('js/custom-switcher.min.js') }}"></script>

        <!-- Jsvectormap & ApexCharts -->
        <script src="{{ asset('libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
        <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Prism JS -->
        <script src="{{ asset('libs/prismjs/prism.js') }}"></script>
        <script src="{{ asset('js/prism-custom.js') }}"></script>

        <!-- jQuery (required for Toastr) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Toastr JS (CDN) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

       <!-- noUiSlider CSS -->
        <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
        <!-- noUiSlider JS -->
        <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>


        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>


        <!-- Toast Messages -->
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };

            @if(session('success'))
                Swal.close();
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                Swal.close();
                toastr.error("{{ session('error') }}");
            @endif
        </script>
        <style>
            #price-slider {
                margin-top: 6px;
            }

            .noUi-target {
                height: 38px !important; /* Match input height */
                border-radius: 5px;
                background: #e9ecef;
                box-shadow: none;
                border: 1px solid #ced4da;
            }

            .noUi-horizontal .noUi-handle {
                width: 18px;
                height: 38px !important;
                top: -1px !important; /* Align with track */
                background: #0d6efd;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0,0,0,0.15);
            }

            .noUi-horizontal .noUi-handle:before,
            .noUi-horizontal .noUi-handle:after {
                display: none; /* Hide default lines */
            }

            .noUi-connect {
                background: #0d6efd; /* Bootstrap primary color */
            }

            #range-values {
                margin-top: 10px;
                display: flex;
                justify-content: space-between;
                font-size: 14px;
            }
            /* Match slider height to input */
            #price-slider .noUi-target {
            height: 38px !important; /* Same as .form-control */
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            background: #e9ecef;
            box-shadow: none;
            }

            .noUi-horizontal .noUi-handle {
            width: 20px;
            height: 38px !important;
            top: -1px !important;
            background: #0d6efd;
            border-radius: 4px;
            box-shadow: none;
            border: none;
            }

            .noUi-horizontal .noUi-handle:before,
            .noUi-horizontal .noUi-handle:after {
            display: none;
            }

            .noUi-connect {
            background: #0d6efd;
            }
            .noUi-tooltip {
            font-size: 14px;
            font-weight: 500;
            background: #343a40;
            color: #fff;
            border-radius: 4px;
            padding: 4px 8px;
            top: -40px !important;
            }

        </style>


        <!-- Choices JS -->
        <script src="{{ asset('libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Your Custom JS -->
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/script.js') }}" defer></script>

         <!-- Datatable JS -->
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
        <!-- Index & Custom JS -->
        <script src="{{ asset('js/index.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        

    @stack('scripts')
</body>
</html>
