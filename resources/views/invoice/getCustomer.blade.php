@extends('layouts.app')

@section('title', ' Incoice Creation | Central Invoice System')

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
                    <h2 class="main-content-title fs-24 mb-1">Generate Invoice</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Enter Customer details</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-body">
                        
                            <form method="POST" action="{{ route('businessmodel.store') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">
                                        Selected Website 
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm btn-outline-primary ms-2">
                                            Change Site
                                        </a>
                                    </label>
                                    <input type="text" class="form-control" value="{{ $site->site_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Name <span style="color:red">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" placeholder="Enter Customer Name" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Date <span style="color:red">*</span></label>
                                        <input type="date" name="invoice_date" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Number <span style="color:red">*</span></label>
                                        <input type="text" name="invoice_number" class="form-control" placeholder="Enter Invoice Number" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Amount <span style="color:red">*</span></label>
                                        <input type="number" name="invoice_amount" class="form-control" placeholder="Enter Amount" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Email</label>
                                        <input type="email" name="customer_email" class="form-control" placeholder="Enter Customer Email (optional)">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Mobile</label>
                                        <input type="text" name="customer_mobile" class="form-control" placeholder="Enter Customer Mobile (optional)">
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Proceed to Products</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>

    <div class="modal fade" id="exampleModal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Select a Different Site</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="GET" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="site_id" class="form-label">Choose a site</label>
                            <select name="site_id" id="site_id" class="form-select" required>
                                <option value="">-- Select Site --</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s->id }}">{{ $s->site_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-muted small">Selecting a different site will reload the database connection.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Site</button>
                    </div>
                </form>
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