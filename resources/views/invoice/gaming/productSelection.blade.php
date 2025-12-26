@extends('layouts.app')

@section('title', 'Product Selection | Central Invoice System')

@section('content')

    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-3">Choose Products and Generate Invoice</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}" class="text-primary">Select Site</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Choose Products and Generate Invoice</li>
                        </ol>
                    </div>

                    <div class="mt-3 mt-md-0">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Go back to Site Selection
                        </a>
                    </div>
                </div>

                <!-- Page Header Close -->

                <div class="card custom-card">
                    <div class="card-body shadow rounded">
                        <form id="generate-invoice-form" method="POST" action="{{ route('generate.invoice') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Selected Website <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <input type="text" form="generate-invoice-form" class="form-control"
                                            name="site_name" id="site_name" value="{{ $customer['site_name'] ?? 'N/A' }}"
                                            readonly>
                                        <a href="{{ route('website.edit', ['id' => $site->id]) }}"
                                            class="input-group-text bg-white" title="Edit Site Info">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                    <input type="hidden" form="generate-invoice-form" name="site_id" id="site_id"
                                        class="form-control" value="{{ $customer['site_id'] }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Invoice Number<span class="text-danger">*</span> <span
                                            class="text-info">(Auto Generated)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                        <input type="text" form="generate-invoice-form" id="invoice_number"
                                            name="invoice_number" class="form-control font-italic"
                                            value="{{ $invoice['invoice_number'] ?? '' }}"
                                            placeholder="Auto-generated invoice number" readonly>
                                        <span style="cursor: pointer;" class="input-group-text" id="copyInvoicenumber"
                                            title="Copy Invoice Number"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" form="generate-invoice-form" name="invoice_date"
                                            class="form-control"
                                            value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" form="generate-invoice-form" class="form-control"
                                            id="customer_name" name="customer_name"
                                            value="{{ $customer['customer_name'] ?? '' }}"
                                            placeholder="Enter Customer Name">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Customer Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" form="generate-invoice-form" class="form-control"
                                            id="customer_email" name="customer_email"
                                            value="{{ $customer['customer_email'] ?? '' }}"
                                            placeholder="Enter Customer email">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_mobile" name="customer_mobile" value="{{ $customer['customer_mobile'] ?? '' }}"  placeholder="Enter customer Mobile">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="accordion mt-3 shadow-sm rounded" id="companyDetailsAccordion">
                <div class="accordion-item border-0 rounded">
                    <h2 class="accordion-header" id="companyDetailsHeading">
                        <button class="accordion-button fw-semibold text-dark bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#companyDetailsCollapse" aria-expanded="false" aria-controls="companyDetailsCollapse">
                            <i class="fas fa-city text-primary me-2"></i>
                            <span class="fw-semibold">Select Company Details Source :</span>
                            <span id="companySourceBadge" class="badge bg-success ms-2">Local</span>
                        </button>
                    </h2>
                    <div id="companyDetailsCollapse" class="accordion-collapse collapse" aria-labelledby="companyDetailsHeading" data-bs-parent="#companyDetailsAccordion">
                        <div class="accordion-body p-2">
                            <div class="row g-2">
                                <div class="col-md-1 border-end">
                                    <div class="list-group list-group-flush h-100 d-flex flex-column justify-content-center" id="companyTypeTab" role="tablist">
                                        @if(!$isWordPress)
                                        <label class="rounded-end-0 list-group-item list-group-item-action d-flex align-items-center gap-2 py-2"
                                            data-bs-toggle="list" href="#websiteDetails" role="tab" style="cursor:pointer;">
                                            <input class="form-check-input visually-hidden" form="generate-invoice-form" type="radio" name="company_detail_type"
                                                id="radioWebsite" value="remote">
                                            <span class="flex-grow-1 fw-semibold text-center rounded d-flex justify-content-center align-items-center">
                                                Remote <span class="ms-1 d-none active-arrow"><i class="fas fa-check"></i></span>
                                            </span>
                                        </label>
                                        @endif
                                        <label class="rounded-end-0 list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 active"
                                            data-bs-toggle="list" href="#customDetails" role="tab" style="cursor:pointer;">
                                            <input class="form-check-input visually-hidden" form="generate-invoice-form" type="radio" name="company_detail_type"
                                                id="radioCustom" value="local" checked>
                                            <span class="flex-grow-1 fw-semibold text-center rounded d-flex justify-content-center align-items-center">
                                                Local <span class="ms-1 d-none active-arrow"><i class="fas fa-check"></i></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="tab-content">

                                        {{-- Website Details Tab --}}
                                        <div class="tab-pane p-0 fade" id="websiteDetails" role="tabpanel">
                                            <div class="p-2 bg-white">
                                                <div class="row g-1 mb-2">
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="remote_site_name" placeholder="Website Name" value="{{ $remote_database->site_name ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="remote_company_mobile" placeholder="Company Mobile" value="{{ $remote_database->phone ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                            <input type="email" form="generate-invoice-form" class="form-control form-control-sm" name="remote_company_email" placeholder="Company Email" value="{{ $remote_database->email ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="remote_registration_number" placeholder="Registration Number" value="{{ $remote_database->registration_number ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-1 mb-2">
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="remote_company_name" placeholder="Company Name" value="{{ $remote_database->company_name ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="remote_company_address" placeholder="Company Address" value="{{ $remote_database->address ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="remote_license_number" placeholder="License Number" value="{{ $remote_database->license_number ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Custom Details Tab --}}
                                        <div class="tab-pane p-0 fade show active" id="customDetails" role="tabpanel">
                                            <div class="p-2 bg-white">
                                                <div class="row g-1 mb-2">
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="local_site_name" placeholder="Website Name" value="{{ $site->site_name ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="local_company_mobile" placeholder="Company Mobile" value="{{ $site->company_mobile ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                            <input type="email" form="generate-invoice-form" class="form-control form-control-sm" name="local_company_email" placeholder="Company Email" value="{{ $site->company_email ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="registration_number" placeholder="Registration Number" value="{{ $site->registration_number ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-1 mb-2">
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="local_company_name" placeholder="Company Name" value="{{ $site->company_name ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="local_company_address" placeholder="Company Address" value="{{ $site->company_address ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                            <input type="text" form="generate-invoice-form" class="form-control form-control-sm" name="license_number" placeholder="License Number" value="{{ $site->license_number ?? '' }}">
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
            </div>

                <div class="card custom-card mt-4">
                    <div class="card-body shadow rounded">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Current Amount</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{ site_currency() }}</span>
                                    <input type="number" form="generate-invoice-form" id="current_amount"
                                        name="current_amount" class="form-control bg-white"
                                        value="{{ $current_total ?? '00.00' }}" readonly>
                                    <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Discount Amount</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{ site_currency() }}</span>
                                    <input type="number" form="generate-invoice-form" name="discount_amount"
                                        id="discount_amount" class="form-control bg-white" placeholder="Discount Amount"
                                        value="0">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{ site_currency() }}</span>
                                    <input form="generate-invoice-form" name="invoice_amount" id="invoice_amount"
                                        class="form-control"
                                        value="{{ number_format($invoice['invoice_amount'], 2, '.', '') }}"
                                        type="number">
                                    <span class="input-group-text" id="update_invoice_amount"
                                        style="cursor:pointer;width: 40px;"><i data-feather="edit"
                                            id="icon"></i></span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            <div class="card custom-card mt-4 border-1 rounded shadow rounded">
                <div class="border-1 rounded shadow rounded card-header bg-light d-flex justify-content-between align-items-center flex-wrap border-bottom pb-3">
                    <h5 class="mb-2 mb-md-0">Search & Filter Products</h5>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                        <button type="button" class="btn btn-outline-success me-1" data-bs-toggle="modal" data-bs-target="#addgames" onclick="customizeProducts('onload')">
                            <i class="bi bi-plus-circle"></i> Add Games
                        </button>
                        {{-- <button type="button" class="btn btn-outline-info me-1" onclick="setCustomOnly()">
                            <i class="bi bi-pencil-square"></i> Custom
                        </button> --}}
                            <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 me-1"
                                onclick="clearAllProducts(this)">
                                <i class="fa-solid fa-filter-circle-xmark"></i>Clear All
                            </button>
                            <button type="button" class="btn btn-outline-warning me-1"
                                onclick="generateRandomProducts('random')">
                                <i class="bi bi-shuffle"></i> Randomize
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="generateInvoice(event)">
                                <i class="bi bi-receipt"></i> Generate Invoice
                            </button>
                        </div>

                    </div>


                    <div class="card-body mt-1">
                        <!-- Search Filters -->
                        <form method="GET" action="#" class="mb-4">
                            <div class="row align-items-end g-3">
                                <!-- Number of Products -->
                                <div class="col-md-4 text-center">
                                    <label for="productCountInput" class="form-label">Number of Products</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                        <input type="number" name="product_count" id="productCountInput"
                                            class="form-control" placeholder="Enter number of products" min="1">
                                    </div>
                                </div>

                                <!-- Keyword Search -->
                                <div class="col-md-4 text-center">
                                    <label for="keywordInput" class="form-label">Search for Products</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" name="manual_keyword" id="keywordInput"
                                            class="form-control"
                                            placeholder="Type a keyword and wait for 1.5 seconds to apply the filter.">
                                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="col-md-4 text-center">
                                    <label class="form-label d-block">Price Range</label>
                                    <div id="price-slider" class="w-100 mx-auto"></div>
                                    <input type="hidden" name="price_from" id="hidden_price_from_input_id">
                                    <input type="hidden" name="price_to" id="hidden_price_to_input_id">
                                </div>
                            </div>
                        </form>


                        <!-- Combined Table -->
                        <div class="table-responsive border rounded">
                            <div id="product-table-wrapper" style="position: relative;">
                                <div id="table-blocker"
                                    style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.6); z-index: 5; cursor: not-allowed;">
                                </div>
                                <table class="table table-hover table-bordered align-middle shadow-sm rounded"
                                    id="productTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>SR. NO.</th>
                                            <th>GAME NAME</th>
                                            <th>GAME CURRENCY</th>
                                            <th>GAME CURRENCY AMOUNT</th>
                                            <th>UNIT PRICE</th>
                                            <th>EDIT PRICE</th>
                                            <th>REMOVE</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-table-body">
                                        <!-- Injected by AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- Modal for Custom Game Selection --}}

    <div class="modal fade" id="addgames" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addGamesLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div
                    class="modal-header bg-white shadow-sm rounded-3 p-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-sliders-h text-primary fs-4 me-2"></i>
                        <h5 class="modal-title fw-semibold text-dark mb-0" id="addGamesLabel">
                            Customize Your Game Selection
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body bg-white">
                    <div class="container-fluid">

                        <!-- Search Section -->
                        <div class="row g-3 mb-4 justify-content-center">
                            <div class="col-md-6">
                                <label for="keywordInput" class="form-label text-center fw-semibold mb-2">Search by
                                    Keyword</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="modalkeywordInput"
                                        placeholder="Enter or speak product or category name...">
                                    <button class="btn btn-outline-secondary" type="button" onclick="startVoiceSearch()"
                                        id="micBtn" title="Voice Search">
                                        <i class="fas fa-microphone" id="micIcon"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="customizeProducts('search')">Search</button>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Summary Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="bg-light rounded border shadow-sm p-3 text-center">
                                    <div class="text-muted small fw-semibold">Current Amount</div>
                                    <div class="fw-bold text-success fs-5">{{ site_currency() }}<span
                                            id="temp_current_amount_text">0.00</span></div>
                                    <input type="hidden" id="modal_current_amount" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light rounded border shadow-sm p-3 text-center">
                                    <div class="text-muted small fw-semibold">Discount Amount</div>
                                    <div class="fw-bold text-danger fs-5">{{ site_currency() }}<span
                                            id="temp_discount_amount_text">0.00</span></div>
                                    <input type="hidden" id="modal_discount_amount" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light rounded border shadow-sm p-3 text-center">
                                    <div class="text-muted small fw-semibold">Invoice Amount</div>
                                    <div class="fw-bold text-warning fs-5">{{ site_currency() }}<span
                                            id="temp_invoice_amount_text">0.00</span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Table Section -->
                        <div class="table-responsive border rounded shadow-sm">
                            <table class="table table-bordered table-hover align-middle mb-0"
                                id="customize-products-table" style="width: 100%;">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>SR. NO.</th>
                                        <th>GAME NAME</th>
                                        <th>GAME CURRENCY</th>
                                        <th>GAME CURRENCY AMOUNT</th>
                                        <th>UNIT PRICE</th>
                                        <th>SELECT</th>
                                    </tr>
                                </thead>
                                <tbody id="customize-product-table-body"></tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="closeFilters()">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger" onclick="clearFilters()">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                        </button>
                        <button type="button" id="add-custom-products" class="btn btn-primary">
                            <i class="bi bi-cart-plus me-1"></i> Add to list
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let sessionAmount = parseFloat("{{ session('invoice_amount') ?? 0 }}");

            function setEditIcon() {
                $('#update_invoice_amount')
                    .removeClass('bg-warning bg-success')
                    .addClass('bg-light')
                    .html('<i data-feather="edit" id="icon" style="color: black;width:20px;"></i>');
                feather.replace();
            }

            function setUploadIcon() {
                $('#update_invoice_amount')
                    .removeClass('bg-light bg-success')
                    .addClass('bg-warning')
                    .html('<i data-feather="upload-cloud" id="icon" style="color: black;width:20px;"></i>');
                feather.replace();
            }

            function setLoader() {
                $('#update_invoice_amount')
                    .removeClass('bg-warning bg-light bg-success')
                    .addClass('bg-warning')
                    .html(
                        '<div class="d-flex align-items-center justify-content-center" style="width:20px;">' +
                        '<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">' +
                        '<span class="visually-hidden">Loading...</span>' +
                        '</div>' +
                        '</div>'
                    );
            }

            function setSuccessIcon() {
                $('#update_invoice_amount')
                    .removeClass('bg-warning')
                    .addClass('bg-success')
                    .html('<i data-feather="check-circle" id="icon" style="color: white;width:20px;"></i>');
                feather.replace();
            }

            $('#invoice_amount').on('input', function() {
                let currentVal = parseFloat($(this).val());
                if (!isNaN(currentVal) && currentVal !== sessionAmount) {
                    setUploadIcon();
                } else {
                    setEditIcon();
                }
            });

            $(document).on('click', '#update_invoice_amount', function() {
                let currentVal = parseFloat($('#invoice_amount').val());
                if (isNaN(currentVal) || currentVal === sessionAmount) {
                    return;
                }

                setLoader();

                let invoice_amount = $('#invoice_amount').val();
                let invoice_date = $('#invoice_date').val();
                let customer_name = $('#customer_name').val();
                let customer_email = $('#customer_email').val();
                let customer_mobile = $('#customer_mobile').val();

                $.ajax({
                    url: "{{ route('update.invoice.amount') }}",
                    type: 'POST',
                    data: {
                        invoice_amount,
                        invoice_date,
                        customer_name,
                        customer_email,
                        customer_mobile,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            sessionAmount = parseFloat(invoice_amount);
                            setSuccessIcon();

                            $('#invoice_amount').val(response.updated.invoice_amount);
                            $('#invoice_date').val(response.updated.invoice_date);
                            $('#customer_name').val(response.updated.customer_name);
                            $('#customer_email').val(response.updated.customer_email);
                            $('#customer_mobile').val(response.updated.customer_mobile);
                            generateRandomProducts();

                            setTimeout(() => {
                                setEditIcon();
                            }, 4000);
                        }
                    },
                    error: function() {
                        setEditIcon();
                    }
                });
            });
        });
    </script>

@endpush
