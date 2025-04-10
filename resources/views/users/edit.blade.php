@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')

    @include('partials.mainhead')
    @include('partials.switcher')
    @include('partials.loader')
    @include('partials.header')
    @include('partials.sidebar')

    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">

    <div class="page">

        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->

                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">Edit User: {{ $user->name }}</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Update User</a></li>
                        </ol>
                    </div>
                </div>

                <!-- Page Header Close -->


                <div class="col-xl-12">
                    <div class="card custom-card">

                        <div class="card-body">
                            <form class="row g-3 mt-0" action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password <small class="text-muted">(Leave blank to keep unchanged)</small></label>
                                    <input type="password" class="form-control" name="password">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select form-select-lg" required>
                                        <option disabled>Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    {{-- <input type="hidden" name="status" value="0"> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck3" name="status" value="1" {{ old('status', $user->status) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck3">Active</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Update User</button>
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
