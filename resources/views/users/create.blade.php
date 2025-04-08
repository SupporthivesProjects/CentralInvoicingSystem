{{--
@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Add New User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Roles</label>
            <select name="roles[]" class="form-control" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Add User</button>
    </form>



</div>

<div class="container mt-5">
    <div class="card">
        <div class="card-header justify-content-between">
            <div class="card-title">Vertical Forms</div>
        </div>

        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Enter Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Enter Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Enter Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>



@endsection
--}}

@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')


    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">

    <div class="page">

        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->

                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">Add Users</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add</li>
                        </ol>
                    </div>
                </div>

                <!-- Page Header Close -->


                <div class="col-xl-12">
                    <div class="card custom-card">

                        <div class="card-body">
                            <form class="row g-3 mt-0" action="{{ route('users.store') }}" method="POST">
                                @csrf

                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select form-select-lg" required>
                                        <option disabled>Select Roles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ (collect(old('roles'))->contains($role->id)) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck3" name="status" value="1" checked>
                                        <label class="form-check-label" for="gridCheck3">Active</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Add User</button>
                                </div>
                            </form>

                        </div>
                        <div class="card-footer d-none border-top-0">

                            <!-- Prism Code -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-6 -->

        </div>
    </div>


    @include('partials.commonjs')

    <!-- JSVector Maps JS -->
    <script src="{{ asset('libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
    <!-- Apex Charts JS -->
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Main-Dashboard -->
    <script src="{{ asset('js/index.js') }}"></script>

    @include('partials.custom_switcherjs')

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
