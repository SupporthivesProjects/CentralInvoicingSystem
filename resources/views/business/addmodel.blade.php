@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@push('styles')
<link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
<link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
@endpush

@section('content')
    @include("partials/mainhead")
    @include("partials/switcher")
    @include("partials/loader")
    @include("partials/header")
    @include("partials/sidebar")

    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Add Business Model</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Business</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Centered Form Row -->
            <div class="row justify-content-center">
    

                <div class="col-md-6">
                @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card custom-card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('businessmodel.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Business Model Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Business Model Name" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Add Business Model</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer d-none border-top-0">
                            <!-- Optional Code Section -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


    @include("partials/commonjs")

<@push('scripts')
<script src="{{ asset('libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@include("partials/custom_switcherjs")


@endsection