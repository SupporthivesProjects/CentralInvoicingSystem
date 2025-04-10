@extends('layouts.app')

@section('title', 'Login | Central Invoice System')

@section('content')
<div class="page main-signin-wrapper">

        <!-- Start::row-1 -->
        <div class="row signpages text-center">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 position-absolute">
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
                                            <p class="mb-4 text-muted fs-13 ms-0 text-start">Sign in to access the Admin and Staff Dashboard</p>
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
                                        <div class="mb-1">
                                            <small class="text-muted">Can't remember your password?</small><br>
                                            <a href="{{ route('password.request') }}">Forgot password?</a>
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
        <!-- End::row-1 -->

    </div>
    
@endsection

@push('scripts')
@endpush
