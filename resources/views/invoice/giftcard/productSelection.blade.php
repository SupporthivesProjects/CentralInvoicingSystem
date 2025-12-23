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
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}" class="text-primary">Select Site</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Choose Products and Generate Invoice</li>
                </ol>
            </div>

                <div class="mt-3 mt-md-0">
                <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm" >
                    <i class="fas fa-arrow-left"></i> Go Back
                </a>
               
                </div>
                </div>
            </div>

            <!-- Page Header Close -->

            <div class="card custom-card">
                <div class="card-body shadow rounded">
                    <form id="generate-invoice-form" method="POST" action="{{ route('generate.invoice') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Selected Website ({{ $customer['site_id'] }})<span class="text-danger">*</span></label>
                                <div class="input-group">
                                 <span class="input-group-text"><i class="fas fa-globe"></i></span> 
                                    <input type="text" form="generate-invoice-form" class="form-control" name="site_name" id="site_name" value="{{ $customer['site_name'] ?? 'N/A' }}" readonly>
                                    <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#sitechangemodel"><i class="fas fa-sync-alt text-primary" style="cursor: pointer;"></i></span>
                                </div>
                                <input type="hidden" form="generate-invoice-form" name="site_id" id="site_id" class="form-control" value="{{ $customer['site_id'] }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="customer_name" name="customer_name" value="{{ $customer['customer_name'] ?? '' }}" placeholder="Enter Customer Name">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="invoice_number" class="form-label">
                                    Invoice Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <input type="text" form="generate-invoice-form" id="invoice_number" name="invoice_number" class="form-control font-italic" value="{{ $invoice['invoice_number'] ?? '' }}" placeholder="Enter or generate invoice number">
                                    <div class="btn-group">
                                            <button type="button" class="btn input-group-text dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item py-1 px-3" href="#" id="generateInvoiceNumber"><i class="fas fa-sync-alt me-2"></i>Generate</a>
                                                </li>
                                                <li><a class="dropdown-item py-1 px-3" href="#" id="copyInvoicenumber"><i class="fas fa-copy me-2"></i>Copy</a>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                            </div>
                            
                           
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" form="generate-invoice-form" name="invoice_date" class="form-control" value="{{ $invoice['invoice_date'] ?? now()->toDateString() }}">
                                </div>
                            </div>
                           

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Customer Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" form="generate-invoice-form" class="form-control" id="customer_email" name="customer_email" value="{{ $customer['customer_email'] ?? '' }}"  placeholder="Enter Customer email">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice File Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <input type="text" form="generate-invoice-form" class="form-control" id="invoice_file_name" name="invoice_file_name" value="{{ old('invoice_file_name') }}" placeholder="Enter Invoice File Name">
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
                <div class="card-body shadow-lg rounded">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Current Amount  <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input type="text" form="generate-invoice-form" id="current_amount" name="current_amount" class="form-control bg-white" value="{{ $current_total ?? '00.00' }}" readonly>
                            <span class="input-group-text" style="width: 40px;"><i class="fas fa-money-bill-wave"></i></span> 
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount Amount  <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input type="number" form="generate-invoice-form" name="discount_amount" id="discount_amount" class="form-control bg-white" placeholder="Discount Amount" value="0">
                            <span class="input-group-text" style="width: 40px;"><i class="fas fa-tags"></i></span> 
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ site_currency() }}</span>
                            <input form="generate-invoice-form" name="invoice_amount" id="invoice_amount" class="form-control" value="{{ number_format($invoice['invoice_amount'], 2, '.', '') }}" type="number">
                            <span class="input-group-text" id="update_invoice_amount" style="cursor:pointer;width: 40px;"><i data-feather="edit" id="icon"></i></span> 
                        </div>
                    </div>
                </div>

                   
                </div>
            </div>

            <div class="card custom-card mt-4 border-1 rounded shadow">
                <div class="card-header bg-white shadow-sm rounded-3 p-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-stars text-primary fs-4 me-2"></i>
                        <h4 class="mb-0 fw-semibold text-dark">Build Your Product & Invoice</h4>
                    </div>

                    <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                       <!-- Add Products -->
                        <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1 me-1"
                                onclick="customizeProducts('onload')" 
                                data-bs-toggle="tooltip" title="Add more products manually">
                            <i class="fas fa-plus-square"></i> Add Products
                        </button>

                        <!-- Randomize -->
                        <button type="button" class="btn btn-outline-success d-flex align-items-center gap-1 me-1"
                                onclick="randomizeProducts('semi_random')" 
                                data-bs-toggle="tooltip" title="Auto-select products randomly">
                            <i class="fas fa-random"></i> Randomize
                        </button>

                        <!-- Clear Filter -->
                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 me-1"
                                onclick="clearRandomizedFilter(this)" 
                                data-bs-toggle="tooltip" title="Remove all filters and randomized items">
                            <i class="fa-solid fa-filter-circle-xmark"></i> Clear
                        </button>

                        <!-- Generate Invoice -->
                        <button type="button" class="btn btn-primary d-flex align-items-center gap-1 me-1"
                                onclick="generateInvoice(event)" 
                                data-bs-toggle="tooltip" title="Generate the invoice for selected products">
                            <i class="bi bi-receipt-cutoff"></i> Generate Invoice
                        </button>

                    </div>
                </div>

                <div class="card-body">
                <div class="container">
                <div class="row g-3 justify-content-center mb-3">
                    <div class="col-md-3">
                        <div class="d-flex flex-column align-items-center h-100">
                            <small class="text-muted fw-semibold mb-2">No. of Products</small>
                            <div class="input-group shadow-sm bg-white w-100">
                                <button class="btn btn-outline-primary" type="button" onclick="adjustNoOfProducts('noOfProducts', -1)">−</button>
                                <input type="text" class="form-control text-center" name="noOfProducts" id="noOfProducts" min="1" max="20" placeholder="Auto" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Auto'" readonly>
                                <button class="btn btn-outline-primary" type="button" onclick="adjustNoOfProducts('noOfProducts', 1)">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-column align-items-center h-100 ms-3">
                            <small class="text-muted fw-semibold mb-2">Price Range</small>
                            <div class="w-100 h-100">
                                <div id="randomize-price-slider" class="w-100"></div>
                                <input type="hidden" name="price_from" id="hidden_randomize_price_from_input_id">
                                <input type="hidden" name="price_to" id="hidden_randomize_price_to_input_id">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex flex-column align-items-center h-100">
                            <small class="text-muted fw-semibold mb-2">Product Category</small>
                            <select class="form-select w-100 h-100" name="category_name" id="category_name">
                                <option value="">All Categories</option>

                                @if($site->technology !== 'wordpress')
                                    <option value="Art and Craft">Art and Craft</option>
                                    <option value="Fashion">Fashion</option>
                                    <option value="Food and Drink">Food and Drink</option>
                                    <option value="General">General</option>
                                    <option value="Gifts and Occasions">Gifts and Occasions</option>
                                    <option value="Health and Beauty">Health and Beauty</option>
                                    <option value="Home and Garden">Home and Garden</option>
                                    <option value="Kids, Babies and Toys">Kids, Babies and Toys</option>
                                    <option value="Leisure">Leisure</option>
                                    <option value="Music, Books, Games and Movies">Music, Books, Games and Movies</option>
                                    <option value="Restaurants, Takeaways and Bars">Restaurants, Takeaways and Bars</option>
                                    <option value="Sports, Fitness and Outdoors">Sports, Fitness and Outdoors</option>
                                    <option value="Technology and Electrical">Technology and Electrical</option>
                                    <option value="Telecommunications">Telecommunications</option>
                                    <option value="Travel">Travel</option>
                                @else
                                    @foreach(getCategoryList($site->technology) as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                    </div>

                    </div>

                </div>  
                    <!-- Product Table -->
                    <div class="table-responsive border rounded shadow-sm">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="">
                            <tr>
                                <th class="text-center" style="width: 6%">PID</th>
                                <th class="text-center" style="width: 35%;">Product Name</th>
                                <th class="text-center" style="width: 20%;"> RRP Price </th>
                                <th class="text-center" style="width: 15%;">Discount</th>
                                <th class="text-center  unit-price-header" style="width: 18%;cursor: pointer;" data-column="3" data-order="desc">
                                    <span class="d-inline-flex align-items-center justify-content-center gap-1">
                                        Our Price <i class="bi bi-caret-down-fill"></i>
                                    </span>
                                </th>
                                <th class="text-center" style="width: 6%;">Remove</th>
                            </tr>

                            </thead>
                            <tbody id="randomize-product-table-body">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addmoreproducts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header bg-white shadow-sm rounded-3 p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sliders-h text-primary fs-4 me-2"></i>
                    <h5 class="modal-title fw-semibold text-dark mb-0" id="staticBackdropLabel1">
                        Customize Your Product Selection
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            
            <!-- Modal Body -->
            <div class="modal-body bg-white">
                <div class="container-fluid">
                    <div class="row g-3 mb-4 align-items-end">

                        <div class="col-md-5">
                            <label for="customizeKeywordInput" class="form-label text-center fw-semibold">Search By Keyword</label>
                            <div class="input-group bg-light shadow-sm ms-2">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0" id="customizeKeywordInput" placeholder="Enter or Speak Keyword" id="micBtn" title="Voice Search">
                                <button class="btn btn-light border-0" type="button" title="Voice Search" onclick="startVoiceSearch('customizeKeywordInput','customizeMicIcon')">
                                    <i class="fas fa-microphone text-primary" id="customizeMicIcon"></i>
                                </button>
                            
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label text-center fw-semibold mb-2">Search By Price Range</label>
                            <div class="align-items-center rounded bg-white shadow-sm ms-3">
                                <div class="w-100" id="customize-price-slider"></div>
                            </div>
                            <input type="hidden" id="hidden_customize_price_from_input_id">
                            <input type="hidden" id="hidden_customize_price_to_input_id">
                        </div>
                        <div class="col-md-2">
                            <label for="sort_unit_price" class="form-label text-center fw-semibold">Sort By Price</label>
                            <input type="hidden" name="current_page_number" id="current_page_number" value="1">
                            <select class="form-select" id="sort_unit_price" name="sort_unit_price"  aria-label="Sort By Price">
                                <option value="asc" selected>Low to High</option>
                                <option value="desc">High to Low</option>
                            </select>
                        </div>

                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="bg-light rounded border shadow-sm p-1 text-center">
                                <div class="text-muted small fw-semibold">Current Amount</div>
                                <div class="fw-bold text-primary fs-5">{{ site_currency() }}<span id="temp_current_amount_text">0.00</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded border shadow-sm p-1 text-center">
                                <div class="text-muted small fw-semibold">Discount Amount</div>
                                <div class="fw-bold text-primary fs-5">{{ site_currency() }}<span id="temp_discount_amount_text">0.00</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded border shadow-sm p-1 text-center">
                                <div class="text-muted small fw-semibold">Invoice Amount</div>
                                <div class="fw-bold text-primary fs-5">{{ site_currency() }}<span id="temp_invoice_amount_text">0.00</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rounded shadow-sm p-2"> 
                        <table id="customize-products-table" class="table table-bordered table-hover align-middle mb-0 table-responsive" style="width:100% !important;">
                            <thead class="text-center">
                            <tr>
                                    <th class="text-center" style="width: 6%;">PID</th>
                                    <th class="text-center" style="width: 35%;">Product Name</th>
                                    <th class="text-center" style="width: 20%;"> RRP Price  </th>
                                    <th class="text-center" style="width: 15%;">Discount</th>
                                    <th class="text-center  unit-price-header" style="width: 18%;cursor: pointer;" data-column="3" data-order="desc">
                                       <span class="d-inline-flex align-items-center justify-content-center gap-1">
                                            Our Price <i class="bi bi-caret-down-fill"></i>
                                        </span>
                                    </th>
                                    <th style="width: 6%;">Select</th>
                            </tr>
                            </thead>
                            <tbody id="customize-product-table-body">
                            </tbody>
                        </table>
                        <div id="customize-pagination"></div>
                    </div>
                </div>
                </div>
            
            <div class="modal-footer bg-light border-top">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >
                        <i class="bi bi-x-circle me-1"></i> Close
                    </button>
                    <button type="button" class="btn btn-danger" onclick="customizeProducts('reset')">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                    </button>
                    <button type="button" id="add-custom-products" class="btn btn-primary">
                        <i class="bi bi-cart-plus me-1"></i> Add Selected to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sitechangemodel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-sm overflow-hidden">
            
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="siteChangeModalLabel">Want to change website? </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="GET" action="{{ route('product.selection') }}" id="sitechangemodel-form">
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="new_site_id" class="form-label fw-semibold">Select a New Site</label>
                        <select name="new_site_id" id="new_site_id" class="form-select" required>
                            <option value="">-- Select Site --</option>
                            @foreach($sites as $s)
                                <option value="{{ $s->id }}">{{ $s->site_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="alert alert-warning small py-2 px-3" role="alert">
                        Selecting a different site will refresh the page and re-establish the database connection.
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 rounded-bottom-4 d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
<script>
    $(document).ready(function() {
        $('html, body').animate({ scrollTop: 200 }, 500); 
        $('#current_amount').val('loading...');
        $('#discount_amount').prop('type', 'text').val('loading...').prop('readonly', true);
    });
</script>
<script>
    function adjustNoOfProducts(id, step) {
        const input = document.getElementById(id);
        let val = input.value === 'Auto' || input.value.trim() === '' ? 0 : parseInt(input.value) || 0;

        val += step;

        if (val <= 0) {
            input.value = '';
            input.placeholder = 'Auto';
        } else {
            val = Math.min(val, 20);
            input.value = val;
            input.placeholder = '';
        }

        triggerRandomizeProducts();
    }

    let randomizeTimeout;
    function triggerRandomizeProducts() {
        clearTimeout(randomizeTimeout);
        randomizeTimeout = setTimeout(() => {
            randomizeProducts('semi_random');
        }, 1500);
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('noOfProducts').addEventListener('change', triggerRandomizeProducts);
        document.getElementById('category_name').addEventListener('change', triggerRandomizeProducts);
    });
</script>


<script>
    const randomizePriceSlider = document.getElementById('randomize-price-slider');
    const customizePriceSlider = document.getElementById('customize-price-slider');
    const minUnitPrice = @json($min_unit_price);
    const maxUnitPrice = @json($max_unit_price);
    const currency = "{{ site_currency() }}";
    
    const updateHiddenInputs = (min, max, type) => {
        if (type === 'randomize') {
            $('#hidden_randomize_price_from_input_id').val(min).trigger('input');
            $('#hidden_randomize_price_to_input_id').val(max).trigger('input');
        } else if (type === 'customize') {
            $('#hidden_customize_price_from_input_id').val(min).trigger('input');
            $('#hidden_customize_price_to_input_id').val(max).trigger('input');
        }
    };

    noUiSlider.create(randomizePriceSlider, {
        start: [minUnitPrice, maxUnitPrice],
        connect: true,
        step: 5,
        range: { min: minUnitPrice, max: maxUnitPrice },
        tooltips: [true , true], 
        format: {
            to: v => `${currency}${Math.round(v)}`,
            from: v => Number(v.replace(currency, ''))
        }
    });

    noUiSlider.create(customizePriceSlider, {
        start: [minUnitPrice, maxUnitPrice],
        connect: true,
        step: 5,
        range: { min: minUnitPrice, max: maxUnitPrice },
        tooltips: [true, true], 
        format: {
            to: v => `${currency}${Math.round(v)}`,
            from: v => Number(v.replace(currency, ''))
        }
    });

    updateHiddenInputs(minUnitPrice, maxUnitPrice, 'randomize');
    updateHiddenInputs(minUnitPrice, maxUnitPrice, 'customize');

</script>


<script>
    let customizeSliderTimer;
    let randomizeSliderTimer;
    let sortUnitPriceTimer;
    let lastSortUnitPrice = $('#sort_unit_price').val();
   
    customizePriceSlider.noUiSlider.on('change', function (values) {
        clearTimeout(customizeSliderTimer);
        customizeSliderTimer = setTimeout(() => {
            const [min, max] = values.map(v => Math.round(parseFloat(v.replace(currency, ''))));
            updateHiddenInputs(min, max, 'customize');
            customizeProducts('range');
        }, 1500);
    });

    $('#sort_unit_price').on('change', function () {
        const currentSortValue = $(this).val();
        clearTimeout(sortUnitPriceTimer);
        sortUnitPriceTimer = setTimeout(() => {
            if (currentSortValue !== lastSortUnitPrice) {
                lastSortUnitPrice = currentSortValue;
                customizeProducts('range', $('#current_page_number').val() || 1);
            }
        }, 1000);
    });

    $('#customizeKeywordInput').on('keypress', function (e) {
    if (e.which === 13) { 
            e.preventDefault(); 
            customizeProducts();
        }
    });


    randomizePriceSlider.noUiSlider.on('change', function (values) {
        clearTimeout(randomizeSliderTimer);
        randomizeSliderTimer = setTimeout(() => {
            const [min, max] = values.map(v => Math.round(parseFloat(v.replace(currency, ''))));
            Swal.fire({
                title: 'Apply new price range?',
                text: 'This will reset your current filter settings.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Apply',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'p-2 text-sm',
                    title: 'text-base',
                    confirmButtonClass: 'btn btn-sm btn-success',
                    cancelButtonClass: 'btn btn-sm btn-danger'
                },
            width: '350px',
            padding: '1em'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateHiddenInputs(min, max, 'randomize');
                    randomizeProducts('semi_random');
                } else {
                    randomizePriceSlider.noUiSlider.set([minUnitPrice, maxUnitPrice]);
                }
            });
        }, 1000);
    });
</script>

<script>
    let randomizeRequest = null;

    function randomizeProducts(mode = 'smart_random') {
        if (randomizeRequest !== null) {
            randomizeRequest.abort();
        }

        randomizeRequest = $.ajax({
            url: "{{ route('random.products') }}",
            type: 'GET',
            data: {
                site_id: "{{ $customer['site_id'] }}",
                invoice_amount: parseFloat($('#invoice_amount').val()) || 0,
                price_from: $('#hidden_randomize_price_from_input_id').val(),
                price_to: $('#hidden_randomize_price_to_input_id').val(),
                category_name: $('#category_name').val().trim(),
                noOfProducts: $('#noOfProducts').val()
            },
            beforeSend: function () {
                $('#randomize-product-table-body').html(getLoaderRowHTML());
                $('#current_amount').val('Calculating...');
                $('#discount_amount').prop('type', 'text').val('Calculating...').prop('readonly', true);
                $('#current_amount').removeClass('text-danger text-success');
                $('#discount_amount').removeClass('text-danger text-success');
                $('#invoice_amount').removeClass('text-danger text-success');
            },
            success: function (response) {
                $('#discount_amount').val(0.00);
                    calculateTotalPrice();
                if (response.total === 0) {
                    $('#randomize-product-table-body').html(getErrorRowHTML('No results found. Try randomizing or use a different keyword.'));
                    
                    return;
                } else {
                    const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
                    const currentAmount = parseFloat(response.total.toFixed(2));
                    $('#current_amount_text').text(currentAmount.toFixed(2));
                    $('#invoice_amount_text').text(invoiceAmount.toFixed(2));
                    $('#randomize-product-table-body').html(response.tableRows);
                    $('#current_amount').val(currentAmount.toFixed(2));
                    $('#discount_amount').prop('readonly', false).prop('type', 'number');
                    calculateTotalPrice();
                }
            },
            error: function (xhr, textStatus) {
                if (textStatus !== 'abort') {
                    $('#randomize-product-table-body').html(getErrorRowHTML('Oops! Something went wrong. Please try again.'));
                    toastr.error('Failed to fetch random products.', 'Oops!');
                    return;
                }
            },
            complete: function () {
                randomizeRequest = null;
            }
        });
    }

    $(document).ready(function() {
        randomizeProducts('smart_random');
    });
</script>


<script>
    customizeRequest = null;

    function customizeProducts(search_type = 'search', page = 1) {
        console.log("Triggered with type:", search_type);
        console.log("customizeRequest:", customizeRequest);
        $('#addmoreproducts').modal('show');
        if (search_type === 'onload' && customizeRequest !== null) {
            console.log("Blocked onload request because a request is ongoing");
            return;
        }

        if (search_type !== 'onload' && customizeRequest !== null) {
            console.log("Aborting previous request...");
            customizeRequest.abort();
            customizeRequest = null;
        }
        if (search_type === 'reset') {
            $('#customizeKeywordInput').val('');
            customizePriceSlider.noUiSlider.set([minUnitPrice, maxUnitPrice]);
            updateHiddenInputs(minUnitPrice, maxUnitPrice, 'customize');
        }
        


        let btn = $('#add-custom-products');
        btn.prop('disabled', false).html('Add Selected to Cart');

        const priceFrom = $('#hidden_customize_price_from_input_id').val();
        const priceTo = $('#hidden_customize_price_to_input_id').val();
        const customizeKeywordInput = $('#customizeKeywordInput').val();
        const sortUnitPrice = $('#sort_unit_price').val() || 'asc';
        let invoice_amount = parseFloat($('#invoice_amount').val()) || 0;
        let current_amount = parseFloat($('#current_amount').val()) || 0;
        let discountAmount = Math.max(current_amount - invoice_amount, 0);
        
        $('#temp_current_amount_text').text(current_amount.toFixed(2));
        $('#temp_invoice_amount_text').text(invoice_amount.toFixed(2));
        $('#temp_discount_amount_text').text(discountAmount.toFixed(2));

        if (!priceFrom && !priceTo) {
            $('#customize-product-table-body').html(
                getErrorRowHTML('No products found for your keyword. Try a different keyword or adjust the range filter.')
            );
            $('#error-row').fadeIn(300).delay(3000).fadeOut(500);
            return;
        }
        if (!customizeKeywordInput && search_type !== 'onload' && search_type !== 'reset' && search_type !== 'range') {
            toastr.info('Enter or Speak Keyword', 'Keyword missing');
            return;
        }


        $('#customize-product-table-body').html(getProductsSearchRowHTML());

        customizeRequest = $.ajax({
            url: "{{ route('filter.products') }}",
            type: 'GET',
            data: {
                price_from: priceFrom,
                price_to: priceTo,
                search_type: search_type,
                keyword: customizeKeywordInput,
                page: page,
                sort_unit_price: sortUnitPrice
            },
            success: function (response) {
                if (!response.tableRows) {
                    $('#customize-product-table-body').html(
                        getErrorRowHTML('No products found for your keyword. Try a different keyword or adjust the range filter.')
                    );
                    return;
                }

                $('#customize-product-table-body').html(response.tableRows);
                $('#customize-pagination').html(response.paginationHtml);
                $('#current_page_number').val(response.currentPage);
                
                calculateTotalPrice();
            },
            error: function (xhr, textStatus) {
                if (textStatus !== 'abort') {
                    console.error('AJAX Error:', textStatus);
                    $('#customize-product-table-body').html(getErrorRowHTML('Something went wrong while filtering.'));
                    toastr.error('Something went wrong while filtering.', 'Oops!');
                }
            },
            complete: function () {
                console.log("Request complete");
                customizeRequest = null; 
            }
        });
    }

</script>


<script>

function clearRandomizedFilter(button) {
    const icon = $(button).find('i');
    const originalIconClass = 'fa-filter-circle-xmark';
    icon.removeClass(originalIconClass).addClass('fa-spinner fa-spin');

    $.ajax({
        url: "{{ route('clear.products') }}",
        type: 'GET',
        success: function(response) {
            $('input[name="product_ids[]"]').prop('checked', false);
            $('.product-price').val('');
            $('#current_amount').val('0.00');
            $('#discount_amount').val('0.00');
            $('#temp_current_amount_text').text('0.00');
            $('#temp_discount_amount_text').text('0.00');
            $('#temp_invoice_amount_text').text($('#invoice_amount').val());
            $('#randomize-product-table-body').html(getErrorRowHTML('Randomize filter cleared. You can now randomize products again or add custom products.'));
            toastr.success('Randomized products filter has been reset');
            calculateTotalPrice();
            
        },
        error: function(xhr, status, error) {
            icon.removeClass('fa-spinner fa-spin').addClass(originalIconClass);
            toastr.error(error , 'Error clearing randomized products');
        },
        complete: function() {
            icon.removeClass('fa-spinner fa-spin').addClass(originalIconClass);
        }
    });
}
</script>
<script>
    function generateInvoice(event) {
        event.preventDefault();

        const customer_name = $('input[name="customer_name"]');
        const invoice_date = $('input[name="invoice_date"]');
        const selectedProducts = $('input[name="product_ids[]"]:checked');
        const invoiceNumber = $('input[name="invoice_number"]').val();
        const invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        const currentAmount = parseFloat($('#current_amount').val()) || 0;
        const discountAmount = parseFloat($('#discount_amount').val()) || 0;

        if (selectedProducts.length === 0) {
            toastr.error('Please select your products combo...', 'No Product Selected');
            return;
        }
        if ($.trim(customer_name.val()) === '') {
            toastr.error('Customer name cannot be empty.', 'Missing Customer Name');
            return;
        }
        if ($.trim(invoice_date.val()) === '') {
            toastr.error('Invoice date cannot be empty.', 'Missing Invoice Date');
            return;
        }
        if (currentAmount < invoiceAmount) {
            $('#current_amount').addClass('border border-danger');
            setTimeout(() => $('#current_amount').removeClass('border border-danger'), 2000);
            toastr.error('Total is less than invoice amount.', 'Mismatch');
            return;
        }

        const expectedAmount = currentAmount - discountAmount;
        if (Math.abs(expectedAmount - invoiceAmount) > 0.01) {
            const diff = (currentAmount - invoiceAmount).toFixed(2);
            $('#discount_amount').addClass('border border-danger');
            setTimeout(() => $('#discount_amount').removeClass('border border-danger'), 2000);
            
            if (discountAmount > diff) {
                toastr.error(`Discount $${discountAmount} exceeds expected $${diff}.`, 'Discount Too High');
            } else {
                toastr.error(`Apply discount of $${diff} to match invoice amount.`, 'Give Discount');
            }
            return;
        }

        if (!invoiceNumber) {
            toastr.error('Please enter your invoice number or generate one randomly.', 'Invoice Number Missing');
            let blinkCount = 0;
            const interval = setInterval(() => {
                invoiceNumber.toggleClass('border border-danger');
                if (++blinkCount >= 10) {
                    clearInterval(interval);
                    invoiceNumber.removeClass('border border-danger');
                }
            }, 200);
            return;
        }

        $('#generate-invoice-form').find('input[name="product_data[]"]').remove();
        let hasMismatch = false;

        selectedProducts.each(function () {
            const productId = $(this).val();
            const productNameInput = $(`input.product-name[data-product-id="${productId}"]`);
            const productName = productNameInput.val() || '';
            const unitPrice = parseFloat($(`input.product-price[data-product-id="${productId}"]`).val()) || 0;
            const $rrpInput = $(`input.product-rrp[data-product-id="${productId}"]`);
            const siteRRP = parseFloat($rrpInput.val()) || 0;
            const reverseRate = parseFloat($rrpInput.data('reverse-rate')) || 1;
            const productDiscount = parseFloat($(`input.product-discount[data-product-id="${productId}"]`).val()) || 0;
            
            const cardRRP = siteRRP * reverseRate;
            const match = productName.match(/([A-Z]{3})\s*(\d+)/i);
            
            if (match) {
                const nameRRP = parseInt(match[2]);
                const expectedRRP = Math.round(cardRRP);
                
                if (Math.abs(nameRRP - expectedRRP) > 1) {
                    toastr.warning(`PID ${productId}: Name should end with "${expectedRRP}" but found "${nameRRP}"`);
                    productNameInput.css('border', '2px solid red');
                    setTimeout(() => productNameInput.css('border', ''), 3000);
                    hasMismatch = true;
                    return false;
                }
            }

            $('#generate-invoice-form').append($('<input>', {
                type: 'hidden',
                name: 'product_data[]',
                value: JSON.stringify({ 
                    product_id: productId,
                    product_name: productName,
                    unit_price: unitPrice,
                    unit_rrp: siteRRP,
                    unit_discount: productDiscount
                })
            }));
        });

        if (hasMismatch) return false;

        let blinkCount = 0;
        $('#discount_amount, #current_amount, #invoice_amount').css('transition', 'border-color 0.3s ease');

        (function blinkBorder() {
            $('#discount_amount, #current_amount, #invoice_amount').toggleClass('border border-success');
            if (++blinkCount < 30) setTimeout(blinkBorder, 500);
            else $('#discount_amount, #current_amount, #invoice_amount').removeClass('border border-success');
        })();

        Swal.fire({
            title: 'Generating Invoice...',
            html: getPrinterLoaderRowHTML(6),
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            width: '334px',
            height: '280px',
            background: 'rgba(0, 0, 0, 0.1)',
            customClass: { popup: 'p-2 text-center', title: 'text-white' }
        });

        $('#generate-invoice-form')[0].submit();
        playPrinterSound('play');
        setTimeout(() => {
            Swal.close();
            playPrinterSound('stop');
            toastr.success('Invoice is ready and will download shortly.', 'Completed');
        }, 15000);
    }
</script>


<script>
    $(document).ready(function() {
    $('#generateInvoiceNumber').on('click', function() {
        toastr.info('Generating an invoice number for you...', 'Please wait');
        $.ajax({
            url: "{{ route('generate.invoice.number') }}", 
            method: 'GET',
            data: {
                site_name : "{{ $customer['site_name'] }}", 
            },
            success: function(response) {
                if (response.success && response.new_invoice_number) {
                    $('#invoice_number').val(response.new_invoice_number);
                    toastr.success('Invoice number generated successfully.', 'Success');
                } else {
                    toastr.error('Failed to generate invoice number.', 'Error');
                }
            },
            error: function() {
                toastr.error('There was an error generating the invoice number.', 'Error');
            }
        });
    });
});

</script>
<script>
    $('#sitechangemodel').on('shown.bs.modal', function () {
        $('#new_site_id').select2({
            dropdownParent: $('#sitechangemodel'),
            placeholder: "-- Select Site --",
            allowClear: true,
            width: '100%'
        });
       
    });

</script>
<script>
$(document).ready(function () {
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

    $('#invoice_amount').on('input', function () {
        let currentVal = parseFloat($(this).val());
        if (!isNaN(currentVal) && currentVal !== sessionAmount) {
            setUploadIcon();
        } else {
            setEditIcon();
        }
    });

    $(document).on('click', '#update_invoice_amount', function () {
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
            success: function (response) {
                if (response.success) {
                    sessionAmount = parseFloat(invoice_amount); 
                    setSuccessIcon();

                    $('#invoice_amount').val(response.updated.invoice_amount);
                    $('#invoice_date').val(response.updated.invoice_date);
                    $('#customer_name').val(response.updated.customer_name);
                    $('#customer_email').val(response.updated.customer_email);
                    $('#customer_mobile').val(response.updated.customer_mobile);
                    randomizeProducts();
                    setTimeout(() => {
                        setEditIcon();
                    }, 4000);
                }
            },
            error: function () {
                setEditIcon();
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('.unit-price-header').click(function() {
        var $header = $(this);
        var $table = $header.closest('table');
        var $tbody = $table.find('tbody');
        var $rows = $tbody.find('tr').toArray();
        var column = $header.data('column');
        var order = $header.data('order');

        $rows.sort(function(a, b) {
            var A = $(a).find('.unit-price-text').text().trim();
            var B = $(b).find('.unit-price-text').text().trim();

            A = parseFloat(A.replace(/[^\d.-]/g, '')) || 0;
            B = parseFloat(B.replace(/[^\d.-]/g, '')) || 0;

            return (order === 'asc') ? (A - B) : (B - A);
        });

        $.each($rows, function(index, row) {
            $tbody.append(row);
        });

        var newOrder = (order === 'asc') ? 'desc' : 'asc';
        $header.data('order', newOrder);

        $header.find('i')
            .removeClass('bi-caret-down-fill bi-caret-up-fill')
            .addClass(newOrder === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill');
    });
});
</script>

<script>

    function startVoiceSearch(inputId, micIconId) {
        const inputField = document.getElementById(inputId);
        const micIcon = document.getElementById(micIconId);
        inputField.placeholder = "Please speak product name or category";

        if (!('SpeechRecognition' in window || 'webkitSpeechRecognition' in window)) {
            toastr.error("Your browser does not support voice recognition. Please try using a modern browser like Chrome.");
            return;
        }

        inputField.value = '';
        inputField.placeholder = "Listening to your voice search...";
        micIcon.classList.remove("text-primary");
        micIcon.classList.add("text-danger");

        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = "en-US";
        recognition.interimResults = false;

        recognition.start();

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            inputField.style.color = "blue";
            inputField.value = transcript;
        };

        recognition.onerror = function(event) {
            toastr.error("Voice recognition error: " + event.error);
            inputField.value = '';
            inputField.style.color = '';
            micIcon.classList.remove("text-danger");
            micIcon.classList.add("text-primary");
            inputField.placeholder = "Enter or Speak Keyword";
        };

        recognition.onend = function() {
            micIcon.classList.remove("text-danger");
            micIcon.classList.add("text-primary");
            inputField.style.color = 'blue';
            inputField.placeholder = "Enter or Speak Keyword";
        };
    }

</script>
<script>
    let discountManuallyChanged = false;

    $(document).on('input', '.product-price, input[name="product_ids[]"], .product-discount, .product-rrp', function () {
        discountManuallyChanged = false;
        calculateTotalPrice();
    });

    $(document).on('input', '#discount_amount', function () {
        discountManuallyChanged = true;
        calculateTotalPrice();
    });

    $(document).on('blur', '#discount_amount', function () {
        calculateTotalPrice();
    });

    function calculateTotalPrice() {
        let currentAmount = 0; 
        initTooltips();
        $('input[name="product_ids[]"]:checked').each(function () {
            const productId = $(this).val();
            const unitPriceInput = $(`.product-price[data-product-id="${productId}"]`);
            const unitPrice = parseFloat(unitPriceInput.val()) || 0;
            currentAmount += unitPrice;
        });

        let invoiceAmount = parseFloat($('#invoice_amount').val()) || 0;
        let discountAmount = parseFloat($('#discount_amount').val()) || 0;

        if (!discountManuallyChanged) {
            discountAmount = currentAmount > invoiceAmount ? currentAmount - invoiceAmount : 0;
            $('#discount_amount').val(discountAmount.toFixed(2));
        }

        $('#current_amount').val(currentAmount.toFixed(2));
        $('#temp_current_amount_text').text(currentAmount.toFixed(2));
        $('#temp_discount_amount_text').text(discountAmount.toFixed(2));
        $('#invoice_amount').val(invoiceAmount.toFixed(2));
        $('#temp_invoice_amount_text').text(invoiceAmount.toFixed(2));

        const expectedTotal = invoiceAmount + discountAmount;
        const isMatch = Math.abs(currentAmount - expectedTotal) < 0.01;
        const colorClass = isMatch ? 'text-success' : 'text-danger';

        $('#current_amount, #discount_amount, #invoice_amount').removeClass('text-success text-danger').addClass(colorClass);
    }

    $(document).ready(function () {
        function updateUnitPrice($row) {
            const canEditRRP = !$row.find('.product-rrp').is('[readonly]');
            const canEditDiscount = !$row.find('.product-discount').is('[readonly]');
            if (!canEditRRP && !canEditDiscount) {
                toastr.warning('Both RRP and Discount fields are not editable.');
                return;
            }

            const rrp = parseFloat($row.find('.product-rrp').val()) || 0;
            const discount = parseFloat($row.find('.product-discount').val()) || 0;
            const discountedPrice = rrp - (rrp * discount / 100);
            $row.find('.product-price').val(discountedPrice.toFixed(2)).trigger('input');
            $row.find('.unit-price-text').text(discountedPrice.toFixed(2));
        }

        $(document).on('input change', '.product-rrp, .product-discount', function () {
            const $row = $(this).closest('.product-row');
            updateUnitPrice($row);
        });
    });
</script>

<script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (el) {
            if (!el._tooltipInitialized) {
                new bootstrap.Tooltip(el);
                el._tooltipInitialized = true;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initTooltips();
    });

    document.addEventListener('click', function (e) {
        const tooltipEl = e.target.closest('[data-bs-toggle="tooltip"]');
        if (tooltipEl) {
            e.stopPropagation();
        }
    });
</script>
@endpush
