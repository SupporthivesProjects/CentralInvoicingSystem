@extends('layouts.app')

@section('title', 'Forgot Password | Central Invoice System')



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
                                    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">>
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
@endsection

@push('scripts')
<script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', function () {
        Swal.fire({
            title: 'Sending reset link...',
            html: `
                <div class="d-flex flex-column align-items-center">
                    <div class="spinner-border text-primary" role="status"></div>
                    <small class="mt-2">Just a sec! Your reset link is zooming its way to your inbox.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>

@endpush
