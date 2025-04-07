@extends('layouts.app')

@section('title', 'Forgot Password | Central Invoice System')

@push('styles')
    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
    
@endpush

@section('content')

<div class="page main-signin-wrapper">

<!-- Start::row-1 -->
<div class="row signpages text-center">
    <div class="col-md-12">
        <div class="card">
            <div class="row row-sm">
                <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                    <div class="mt-3 pt-3 p-2 position-absolute">
                        
                        <div class="clearfix"></div>
                        <img src="{{ asset('images/svgs/user.svg') }}" class="ht-100 mb-0" alt="user">
                        <h5 class="mt-4">Forgot Password</h5>
                        <span class="text-white-6 fs-13 mb-5 mt-xl-0">Signup to create, discover and connect with the global community</span>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
                    <div class="main-container container-fluid">
                        <div class="row row-sm">
                            <div class="card-body mt-2 mb-2">
                                <div class="clearfix"></div>
                                <h5 class="text-start mb-2">Forgot Password</h5>
                                <p class="mb-4 text-muted fs-13 ms-0 text-start">Enter your registered email address. We’ll send you a link to reset your password.</p>
                                <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                    <div class="form-group text-start">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" placeholder="Enter your email" type="email" name="email" required>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit" >Request reset link</button>
                                    </div>
                                </form>
                                <div class="card-footer border-top-0 ps-0 mt-3 text-start ">
                                    <p class="mb-1">Did you remembered your password?</p>
                                    <p class="mb-0">Try to <a href="{{ route('login') }}">Signin</a></p>
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
