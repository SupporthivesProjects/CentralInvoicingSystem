@extends('layouts.app')

@section('title', 'Login | Central Invoice System')

@section('content')
<div class="main-signin-wrapper">
    <div class="row signpages text-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4 mb-0">
                <div class="row row-sm">
                    <div class="col-lg-6 col-xl-5 d-none d-lg-flex bg-primary text-white text-center d-flex justify-content-center align-items-center p-5 animate__animated animate__fadeInLeft animate__delay-03s">
                        <div>
                            <img src="{{ asset('images/svgs/user.svg') }}" class="mb-4" style="width: 120px;">
                            <h3 class="fw-bold">Welcome Back, Admin</h3>
                            <p class="text-white-50 px-3">Please sign in to access the Central Invoice System’s admin panel.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form">
                        <div class="container-fluid">
                            <div class="row row-sm">
                                <div class="card-body mt-2 mb-2">
                                    <div class="text-center mb-4 animate__animated animate__fadeIn animate__delay-06s">
                                        <img src="{{ asset('images/brand-logos/central_invoice.png') }}" alt="logo" class="mb-3" style="max-width: 160px;">
                                    </div>

                                    <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
                                        @csrf
                                        <h5 class="text-center mb-2 fw-bold animate__animated animate__fadeIn animate__delay-09s">Sign In to Your Account</h5>
                                        <p class="text-center text-muted fs-6 mb-4 animate__animated animate__fadeIn animate__delay-12s">Access your dashboard and manage the Central Invoice System with ease.</p>

                                        <div class="form-group text-start mb-3 animate__animated animate__fadeIn animate__delay-15s">
                                            <label class="form-label">Email Address</label>
                                            <input class="form-control" placeholder="Enter your email" type="email" name="email" required>
                                        </div>

                                        <div class="form-group text-start mb-3 animate__animated animate__fadeIn animate__delay-15s">
                                            <label class="form-label">Password</label>
                                            <input class="form-control" placeholder="Enter your password" type="password" name="password" id="password" required>
                                        </div>

                                        <div class="d-grid mb-3 animate__animated animate__fadeIn animate__delay-18s">
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm btn-hover-effect">Sign In</button>
                                        </div>
                                    </form>

                                    <div class="text-start ms-0">
                                        <div class="mb-1">
                                            <small class="text-muted">Forgot your password?</small><br>
                                            <a href="{{ route('password.request') }}">Click here to reset it</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    document.getElementById('loginForm').addEventListener('submit', function () {
        Swal.fire({
            title: 'Logging You In...',
            html: `
                <div class="d-flex flex-column align-items-center">
                    <div class="loaderBar"></div>
                    <small class="mt-3 fs-6">Please wait while we securely log you in and prepare your account.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>
@endpush
