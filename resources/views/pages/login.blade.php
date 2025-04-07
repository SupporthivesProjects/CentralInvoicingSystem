@extends('layouts.app')

@section('title', 'Login | Central Invoice System')

@push('styles')
    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
    
@endpush

@section('content')
<div class="page main-signin-wrapper">

        <!-- Start::row-1 -->
        <div class="row signpages text-center">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 position-absolute">
                                <a href="index.html">
                                    <img src="{{ asset('images/brand-logos/desktop-white.png') }}" class="header-brand-img mb-4" alt="logo">
                                </a>
                                <div class="clearfix"></div>
                                <img src="{{ asset('images/svgs/user.svg') }}" class="ht-100 mb-0" alt="user">
                                <h5 class="mt-4 text-white">Welcome Back, Admin!</h5>
                                <span class="text-white-6 fs-13 mb-5 mt-xl-0">Sign in to access the Central Invoice System admin panel</span>

                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
                            <div class="main-container container-fluid">
                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                   
                                        <div class="clearfix"></div>
                                        <form method="POST" action="{{ route('login.submit') }}">
                                        @csrf
                                            <h5 class="text-start mb-2">Signin to Your Account</h5>
                                            <p class="mb-4 text-muted fs-13 ms-0 text-start">Signin to create, discover and connect with the global community</p>
                                            <div class="form-group text-start">
                                                <label class="form-label">Email</label>
                                                <input class="form-control" placeholder="Enter your email" type="email" name="email" required>
                                            </div>
                                            <div class="form-group text-start">
                                                <label class="form-label">Password</label>
                                                <input class="form-control" placeholder="Enter your password" type="password" name="password" id="password" required>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Sign In</button>
                                            </div>
                                        </form>
                                        <div class="text-start mt-5 ms-0">
                                            <div class="mb-1"><a href="forgot.html">Forgot password?</a></div>
                                            <div>Don't have an account? <a href="signup.html">Register Here</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-1 -->

    </div>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toast Messages -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- Include common JS and custom switcher JS -->
    @include("partials.commonjs")
    @include("partials.custom_switcherjs")
@endpush
