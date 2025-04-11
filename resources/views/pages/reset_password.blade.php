@extends('layouts.app')

@section('title', 'Reset Password | Central Invoice System')

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
                        <h5 class="mt-4">Reset Your Password</h5>
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
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <div class="form-group text-start">
                                        <label class="form-label">New password</label>
                                        <input class="form-control" placeholder="Enter your email" type="password" name="password" id="password" required>
                                    </div>
                                    <div class="form-group text-start">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control" placeholder="Enter your email" type="password" name="password_confirmation" id="password_confirmation"  required>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit" >Reset Password</button>
                                    </div>
                                </form>
                              
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
