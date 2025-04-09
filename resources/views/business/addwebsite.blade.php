@extends('layouts.app')

@section('title', 'Connect New Website | Central Invoice System')

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
                    <h2 class="main-content-title fs-24 mb-1">Manage Sites</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Connect New Website</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Enter Details</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Form -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('website.store') }}" enctype="multipart/form-data" class="row g-3 mt-0">
                            @csrf

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Business Model <span style="color:red">*</span></label>
                                <select name="business_model_id" class="form-select" required>
                                    <option selected disabled>Choose Business Model</option>
                                    @foreach ($businessModels as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Name <span style="color:red">*</span></label>
                                <input type="text" name="site_name" class="form-control" required placeholder="Enter Site Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Description</label>
                                <input type="text" name="site_description" class="form-control" placeholder="Enter Site Description (optional)">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Host <span style="color:red">*</span></label>
                                <input type="text" name="db_host" class="form-control" placeholder="Enter Database Host" required>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Port <span style="color:red">*</span></label>
                                <input type="text" name="db_port" class="form-control" placeholder="Enter Database Port" value="3306"  required>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Name <span style="color:red">*</span></label>
                                <input type="text" name="db_name" class="form-control" placeholder="Enter Database Name" required>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Username <span style="color:red">*</span></label>
                                <input type="text" name="db_username" class="form-control" placeholder="Enter Database Username" required>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Password <span style="color:red">*</span></label>
                                <input type="text" name="db_password" class="form-control" placeholder="Enter Database Password" required>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Website Link</label>
                                <input type="text" name="site_link" class="form-control" placeholder="Enter Website link">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Remark</label>
                                <input type="text" name="remark" class="form-control" placeholder="Enter Remark here in case">
                            </div>
                            <!-- Company Details Section -->
                            <div class="col-12">
                                <hr>
                                <h5 class="text-left">Company Details (Optional)</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control" placeholder="Enter Company Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Email</label>
                                <input type="email" name="company_email" class="form-control" placeholder="Enter Company Email">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Mobile</label>
                                <input type="text" name="company_mobile" class="form-control" placeholder="Enter Company Mobile">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Address</label>
                                <textarea name="company_address" class="form-control" rows="2" placeholder="Enter Company Address"></textarea>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Logo</label>
                                <input type="file" name="company_logo" class="form-control">
                            </div>

                            <!-- Invoice Header Image -->
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Invoice Header Image</label>
                                <input type="file" name="invoice_header_image" class="form-control">
                            </div>

                            <!-- Invoice Footer Image -->
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Invoice Footer Image</label>
                                <input type="file" name="invoice_footer_image" class="form-control">
                            </div>

                            <!-- Invoice Signature -->
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Invoice Signature</label>
                                <input type="file" name="invoice_signature" class="form-control">
                            </div>
                            <!-- Invoice Template (HTML file only) -->
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Invoice Template</label>
                                <input type="file" name="invoice_template" class="form-control" accept=".html">
                                <small class="form-text text-muted">Please upload an HTML file only. Max size: 2MB.</small>
                            </div>
                            

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary mt-2">Add Website</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-none border-top-0"></div>
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