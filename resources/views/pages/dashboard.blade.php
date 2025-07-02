@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::page-header -->

                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">Welcome To Dashboard</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Central Invoice System</li>
                        </ol>
                    </div>
                    <div class="d-flex">
                        <div class="justify-content-center">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#generateReportModal" class="btn btn-primary my-2 btn-icon-text d-inline-flex align-items-center">
                                <i class="fe fe-download-cloud me-2 fs-14"></i> Download Report
                            </button>
                        </div>
                    </div>
                </div>

                <!-- End::page-header -->

                <!-- Start::row-1 -->
                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12 col-xl-12">

                        <!-- Start::row -->
                        <div class="row row-sm">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body p-3">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.93 6h-3.02c-.2-1.73-.8-3.3-1.64-4.47C16.37 4.28 18.05 5.87 17.93 8zM12 4.04c.84 1.07 1.44 2.64 1.64 4.47h-3.28c.2-1.83.8-3.4 1.64-4.47zM6.07 8c.12-2.13 1.8-3.72 3.66-4.47C8.8 4.7 8.2 6.27 8 8H6.07zM4.43 10h3.45c-.09.98-.14 1.98-.14 3s.05 2.02.14 3H4.43a8.056 8.056 0 0 1 0-6zm1.64 8h2.79c.31 1.19.76 2.27 1.33 3.18C7.16 20.9 5.65 19.6 6.07 18zM12 20c-.84-1.07-1.44-2.64-1.64-4.47h3.28c-.2 1.83-.8 3.4-1.64 4.47zm1.86-.82c.57-.91 1.02-1.99 1.33-3.18h2.79c.42 1.6-1.09 2.9-4.12 3.18zM16.12 16c.09-.98.14-1.98.14-3s-.05-2.02-.14-3h3.45a8.056 8.056 0 0 1 0 6h-3.45z"/>
                                            </svg>


                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Available Websites</label>
                                                  <p class="card-text">All Available Websites</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ getAllWebsites() }}">
                                                            {{ compact_number(getAllWebsites()) }}
                                                        </span>
                                                    </h4>
                                                    <a href="{{ route('connectedwebsites') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body p-3">
                                        <div class="card-item">
                                         <div class="card-item-icon card-icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                            <g>
                                                <rect fill="none" height="24" width="24"/>
                                                <g>
                                                <path fill="currentColor" d="M20,6h-3V4c0-1.1-0.9-2-2-2h-6C7.9,2,7,2.9,7,4v2H4C2.9,6,2,6.9,2,8v12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V8 C22,6.9,21.1,6,20,6z M9,4h6v2H9V4z M20,20H4V8h16V20z"/>
                                                </g>
                                            </g>
                                            </svg>


                                            </div>
                                            <div class="card-item-title mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Business Models</label>
                                                <p class="card-text">All business models</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ getModelsCount() }}">
                                                            {{ compact_number(getModelsCount()) }}
                                                        </span>
                                                    </h4>

                                                    <a href="{{ route('businessmodels') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill="currentColor" fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body p-3">
                                        <div class="card-item">
                                           <div class="card-item-icon card-icon">
                                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="24" width="24">
                                            <g>
                                                <rect fill="none" height="24" width="24"/>
                                                <g>
                                                <path fill="currentColor" d="M17,3H7C5.9,3,5,3.9,5,5v16l2-1.5L9,21l2-1.5L13,21l2-1.5L17,21l2-1.5l2,1.5V5C21,3.9,20.1,3,19,3H17z M17,9H7V7h10V9z M17,13H7v-2h10V13z M13,17H7v-2h6V17z"/>
                                                </g>
                                            </g>
                                            </svg>


                                            </div>

                                            <div class="card-item-title  mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">Invoices Created</label>
                                                <p class="card-text">All created invoices</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ invoiceCount() }}">
                                                            {{ compact_number(invoiceCount()) }}
                                                        </span>
                                                    </h4>

                                                    <a href="#listinvoices" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill="currentColor" fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                                <div class="card custom-card">
                                    <div class="card-body p-3">
                                        <div class="card-item">
                                            <div class="card-item-icon card-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 640 512" fill="currentColor">
                                                    <path d="M96 128a80 80 0 1 0 160 0A80 80 0 1 0 96 128zm224 0a80 80 0 1 0 160 0A80 80 0 1 0 320 128zM32 384c0-53 43-96 96-96h64c53 0 96 43 96 96v16c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16v-16zm288 0c0-35.3 28.7-64 64-64h96c35.3 0 64 28.7 64 64v32c0 8.8-7.2 16-16 16H336c-8.8 0-16-7.2-16-16v-32z"/>
                                                </svg>
                                            </div>


                                            <div class="card-item-title  mb-2">
                                                <label class="main-content-label fs-13 fw-bold mb-1">User List</label>
                                                <p class="card-text">All admin and staff users</p>
                                            </div>
                                            <div class="card-item-body">
                                                <div class="card-item-stat">
                                                    <h4 class="fw-bold">
                                                         <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ userCount() }}">
                                                            {{ compact_number(userCount()) }}
                                                        </span>
                                                    </h4>

                                                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill="currentColor" fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <!-- End::row -->

                        @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'developer'))
                            <div class="row row-sm g-3">

                                <!-- My Invoices -->
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card custom-card shadow-sm">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="card-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="26" width="26" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17,3H7C5.9,3,5,3.9,5,5v16l2-1.5L9,21l2-1.5L13,21l2-1.5L17,21l2-1.5l2,1.5V5C21,3.9,20.1,3,19,3H17z M17,9H7V7h10V9z M17,13H7v-2h10V13z M13,17H7v-2h6V17z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <label class="fs-13 fw-bold mb-0">Invoices</label>
                                                <p class="text-muted mb-1 small">Total invoices created by you</p>
                                                <h5 class="fw-bold mb-0">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ myinvoices() }}">
                                                        {{ compact_number(myinvoices()) }}
                                                    </span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- My Websites -->
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card custom-card shadow-sm">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="card-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="26" width="26" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.93 6h-3.02c-.2-1.73-.8-3.3-1.64-4.47C16.37 4.28 18.05 5.87 17.93 8zM12 4.04c.84 1.07 1.44 2.64 1.64 4.47h-3.28c.2-1.83.8-3.4 1.64-4.47zM6.07 8c.12-2.13 1.8-3.72 3.66-4.47C8.8 4.7 8.2 6.27 8 8H6.07zM4.43 10h3.45c-.09.98-.14 1.98-.14 3s.05 2.02.14 3H4.43a8.056 8.056 0 0 1 0-6zm1.64 8h2.79c.31 1.19.76 2.27 1.33 3.18C7.16 20.9 5.65 19.6 6.07 18zM12 20c-.84-1.07-1.44-2.64-1.64-4.47h3.28c-.2 1.83-.8 3.4-1.64 4.47zm1.86-.82c.57-.91 1.02-1.99 1.33-3.18h2.79c.42 1.6-1.09 2.9-4.12 3.18zM16.12 16c.09-.98.14-1.98.14-3s-.05-2.02-.14-3h3.45a8.056 8.056 0 0 1 0 6h-3.45z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <label class="fs-13 fw-bold mb-0">Websites</label>
                                                <p class="text-muted mb-1 small">Websites you've added</p>
                                                <h5 class="fw-bold mb-0">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ mywebsites() }}">
                                                        {{ compact_number(mywebsites()) }}
                                                    </span>
                                                </h5>
                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Last Login -->
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card custom-card shadow-sm">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="card-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="26" width="26" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 7v5l3 3-.75.75L11 13V7h1zm0-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <label class="fs-13 fw-bold mb-0">Logged In Since</label>
                                                <p class="text-muted mb-1 small">Time elapsed since last login</p>
                                                <h5 class="fw-bold mb-0" id="lastLoginTimer"
                                                    data-last-login="{{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->toIso8601String() }}">
                                                    Loading...
                                                </h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Account Status -->
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card custom-card shadow-sm">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="card-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="26" width="26" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <label class="fs-13 fw-bold mb-0">Status</label>
                                                <p class="text-muted mb-1 small">Active or Deactive</p>
                                                <h5 class="fw-bold mb-0">
                                                    @if(auth()->user()->status)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">Deactive</span>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                        <!-- Start::row -->
                        <div class="row" >
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-header border-bottom-0">
                                        <div class="d-flex justify-content-between w-100">
                                            <h4 class="mb-1">Invoice Generation and Price Changes</h4>
                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <p class="text-muted mb-0" style="font-size: 14px;">
                                            This chart displays the number of invoices created (in red) and the number of price changes (in blue) over the last 8 days (the past 7 days plus today).
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div id="invoicechart"></div>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'developer'))
                            <div class="col-sm-12 col-lg-12 col-xl-12">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-header border-bottom-0">
                                        <div class="d-flex justify-content-between w-100">
                                            <h4 class="mb-1">User-wise Invoice Generation</h4>
                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <p class="text-muted mb-0" style="font-size: 14px;">
                                            This chart shows how many invoices each user has created over the last 8 days (the past 7 days plus today). Hover over the chart to see a daily breakdown.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div id="userInvoiceChart"></div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-lg-12" id="listinvoices">
                                <div class="card custom-card mg-b-20 tasks">
                                <div class="card-body">
                                        <h4 class="mb-4">Invoice Generation History</h4>
                                        <div class="table-responsive">
                                            <table id="invoice-history" class="table table-bordered text-nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">Invoice No</th>
                                                        <th class="text-center">Website</th>
                                                        <th class="text-center">Discount</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">Regenerate</th>
                                                        <th class="text-center">User</th>
                                                        <th class="text-center">Created</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoices as $index => $invoice)
                                                        <tr>
                                                            <td class="text-center">{{ $invoice->id }}</td>
                                                            <td class="text-left">{{ $invoice->invoice_number }}</td>
                                                            <td class="text-left">
                                                            @if ($invoice->website && $invoice->website->site_link)
                                                                <a href="{{ $invoice->website->site_link }}" target="_blank" data-bs-toggle="tooltip" title="Model: {{ $invoice->model_type }}">
                                                                    {{ $invoice->website->site_name ?? $invoice->website->site_link }}
                                                                </a>
                                                            @elseif ($invoice->website && $invoice->website->site_name)
                                                                <a href="https://www.google.com/search?q={{ urlencode($invoice->website->site_name) }}" target="_blank" data-bs-toggle="tooltip"  title="Model: {{ $invoice->model_type }}">
                                                                    {{ $invoice->website->site_name }}
                                                                </a>
                                                            @else
                                                                <span class="text-muted">No site info</span>
                                                            @endif

                                                            </td>
                                                            <td class="text-center">{{ $invoice->currency }}{{ number_format($invoice->discount_amount, 2) }} </td>
                                                            <td class="text-center">{{ $invoice->currency }}{{ number_format($invoice->invoice_amount, 2) }}</td>
                                                           
                                                            <td class="text-center">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="{{ route('product.selection', ['invoice_id' => $invoice->id]) }}"
                                                                    class="btn btn-outline-warning rounded-pill btn-sm" data-bs-toggle="tooltip" title="Regenerate the invoice with the same invoice number and amount.">
                                                                        <i class="fas fa-redo-alt"></i> Regenerate
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                @php
                                                                    $user = getUserById($invoice->created_by);
                                                                    $img = $user?->profile?->profile_image;
                                                                @endphp

                                                                @if($user)
                                                                    @if($img && file_exists(public_path($img)))
                                                                        <img src="{{ asset($img) }}" alt="Profile" class="rounded-circle"
                                                                            style="width: 30px; height: 30px; object-fit: cover;"
                                                                            data-bs-toggle="tooltip" title="{{ $user->name }}">
                                                                    @else
                                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                                                            style="width: 30px; height: 30px; font-size: 14px;"
                                                                            data-bs-toggle="tooltip" title="{{ $user->name }}">
                                                                            {{ strtoupper($user->name[0]) }}
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <img src="{{ asset('uploads/profile/default-profile.png') }}" alt="Guest"
                                                                        class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;"
                                                                        data-bs-toggle="tooltip" title="Guest">
                                                                @endif
                                                            </td>

                                                            <td class="text-center">
                                                                {{ $invoice->created_at->setTimezone('Asia/Kolkata')->format('d-m-Y h:i A') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div><!-- col end -->
                        </div>
                        <!-- End::row -->

                        

                    </div><!-- col end -->


                </div>
                <!-- End::row-1 -->
                
            </div>
        </div>
        <!-- End::app-content -->
    </div>
</div>

<div class="modal fade" id="generateReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-semibold" id="generateReportModalLabel">
                    🧾 Invoice Report Generator
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('invoice.report') }}" method="GET">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="business_model_id" class="form-label fw-medium">Business Model</label>
                            <?php $models = getallModels(); ?>
                            <select name="business_model_id" id="business_model_id" class="form-select shadow-sm">
                                <option value="">-- Choose Model --</option>
                                @foreach($models as $model)
                                    <option value="{{ $model->id }}" {{ request()->business_model_id == $model->id ? 'selected' : '' }}>
                                        {{ $model->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="site_id" class="form-label fw-medium">Select Websites</label>
                            <select name="site_id" id="site_id" class="form-select shadow-sm">
                                <option value="all" {{ request()->site_id == 'all' ? 'selected' : '' }}>All Sites</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}" {{ request()->site_id == $site->id ? 'selected' : '' }}>
                                        {{ $site->site_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-medium">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control shadow-sm" value="{{ request()->start_date }}">
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-medium">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control shadow-sm" value="{{ request()->end_date }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between px-4 pb-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-bar-chart-line-fill me-2"></i>View Report
                    </button>
                    <a href="{{ route('invoice.report', [
                        'generate_pdf' => true,
                        'business_model_id' => request()->business_model_id,
                        'site_id' => request()->site_id,
                        'start_date' => request()->start_date,
                        'end_date' => request()->end_date
                    ]) }}" class="btn btn-danger px-4">
                        <i class="bi bi-file-earmark-arrow-down-fill me-2"></i>Download as PDF
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<script>
    const invoiceDates = @json($dates); 
    const invoiceCounts = @json($invoiceCounts);  
    const priceChangeCounts = @json($priceChanges); 
    const siteCurrency = @json(site_currency());
    const chartTypes = ['line'];

    function getRandomType() {
        return chartTypes[Math.floor(Math.random() * chartTypes.length)];
    }

    var chartType = getRandomType();
    console.log("Random Chart Type:", chartType);

    var options = {
        chart: {
            height: 350,
            zoom: { enabled: true },
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true,
                    customIcons: []
                }
            },
            offsetX: 0,
            offsetY: 0
        },
        series: [
            {
                name: "Invoices Created Count",
                type: chartType,
                data: invoiceCounts,
                color: "#FF5733"
            },
            {
                name: "Price Changes Count",
                type: chartType,
                data: priceChangeCounts,
                color: "#1E90FF"
            }
        ],
        xaxis: {
            categories: invoiceDates,
            title: {
                text: 'Date'
            }
        },
        yaxis: {
            title: {
                text: 'Invoice Count'
            },
            min: 0,
            labels: {
                style: {
                    colors: '#666',
                    fontSize: '12px'
                }
            }
        },
        stroke: { curve: 'smooth' },
        dataLabels: { enabled: true },
        tooltip: { shared: true },
        colors: ['#00b3ff', '#28a745', '#ffc107', '#6610f2', '#17a2b8']
    };

    var chart = new ApexCharts(document.querySelector("#invoicechart"), options);
    chart.render();
</script>



<script>
    var options = {
        chart: {
            type: 'area',
            height: 350
        },
        series: @json($userInvoices),
        xaxis: {
            categories: @json($invoicedates),
            title: { text: 'Date' },
            labels: { rotate: -45 }
        },
        yaxis: {
            title: { text: 'Invoice Count' }
        },
        stroke: { curve: 'smooth' },
        dataLabels: { enabled: true },
        tooltip: { shared: true },
        colors: ['#00b3ff', '#28a745', '#ffc107', '#6610f2', '#17a2b8']
    };

    var chart = new ApexCharts(document.querySelector("#userInvoiceChart"), options);
    chart.render();
</script>


<script>
    $(document).ready(function () {
        $('#invoice-history').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            order: [[0, 'desc']], 
            buttons: [
                'csv',
                'excel',
                'pdf'
            ]
        });
    });
</script>

<script>
    function pad(num) {
        return num.toString().padStart(2, '0');
    }

    function updateLiveTimer() {
        const el = document.getElementById('lastLoginTimer');
        const lastLogin = el.getAttribute('data-last-login');

        if (!lastLogin) {
            el.textContent = 'Never';
            return;
        }

        const lastLoginDate = new Date(lastLogin); 
        const now = new Date();

        let diff = Math.floor((now.getTime() - lastLoginDate.getTime()) / 1000); 

        const hrs = Math.floor(diff / 3600);
        diff %= 3600;
        const mins = Math.floor(diff / 60);
        const secs = diff % 60;

        el.textContent = `${pad(hrs)}:${pad(mins)}:${pad(secs)}`;
    }

    updateLiveTimer(); 
    setInterval(updateLiveTimer, 1000); 
</script>


@endpush
