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
                    <h2 class="main-content-title fs-24 mb-1">Manage Site</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Add New business model</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Enter model details</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Centered Form Row -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                        <form method="POST" action="{{ route('businessmodel.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Business Model Name <span style="color:red">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Business Model Name" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Icon Class <span style="color:red">*</span></label>
                                    <input type="text" name="icon_class" class="form-control" placeholder="e.g., fe fe-shopping-cart" required>
                                    <small class="form-text text-muted">Use icon class like <code>fe fe-shopping-cart</code>, <code>fe fe-globe</code>, etc.</small>
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