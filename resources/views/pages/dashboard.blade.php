@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@push('styles')
<style>
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        animation: fadeSlideUp 0.5s ease both;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.12) !important;
    }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.15s; }
    .stat-card:nth-child(3) { animation-delay: 0.25s; }
    .stat-card:nth-child(4) { animation-delay: 0.35s; }

    .admin-card {
        border: none;
        border-radius: 14px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        animation: fadeSlideUp 0.5s ease both;
    }
    .admin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.1) !important;
    }
    .admin-card:nth-child(1) { animation-delay: 0.4s; }
    .admin-card:nth-child(2) { animation-delay: 0.5s; }
    .admin-card:nth-child(3) { animation-delay: 0.6s; }
    .admin-card:nth-child(4) { animation-delay: 0.7s; }

    .chart-card {
        border: none;
        border-radius: 16px;
        animation: fadeSlideUp 0.5s ease 0.8s both;
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }
    .stat-card:hover .icon-box,
    .admin-card:hover .icon-box {
        transform: scale(1.15) rotate(-6deg);
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -1px;
    }

    .view-btn {
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 14px;
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .view-btn:hover {
        transform: translateX(3px);
    }

    .pulse-badge::before {
        content: '';
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        margin-right: 5px;
        animation: pulseDot 1.6s infinite;
        vertical-align: middle;
    }
    .pulse-badge-purple::before { background: #6366f1; }
    .pulse-badge-amber::before  { background: #f59e0b; }
    .pulse-badge-green::before  { background: #10b981; }
    .pulse-badge-red::before    { background: #ef4444; }

    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%       { transform: scale(1.5); opacity: 0.5; }
    }

    .counter-num { display: inline-block; }
</style>
@endpush

@section('content')
<div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

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

            <div class="row row-sm">
            <div class="col-sm-12 col-lg-12 col-xl-12">

                {{-- Row 1 & 2: All 6 Stat Cards (uniform compact horizontal) --}}
                <div class="row row-sm g-3">

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card stat-card shadow-sm h-100" style="border-left: 4px solid #0dbe26;">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24" fill="#0dbe26"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.93 6h-3.02c-.2-1.73-.8-3.3-1.64-4.47C16.37 4.28 18.05 5.87 17.93 8zM12 4.04c.84 1.07 1.44 2.64 1.64 4.47h-3.28c.2-1.83.8-3.4 1.64-4.47zM6.07 8c.12-2.13 1.8-3.72 3.66-4.47C8.8 4.7 8.2 6.27 8 8H6.07zM4.43 10h3.45c-.09.98-.14 1.98-.14 3s.05 2.02.14 3H4.43a8.056 8.056 0 0 1 0-6zm1.64 8h2.79c.31 1.19.76 2.27 1.33 3.18C7.16 20.9 5.65 19.6 6.07 18zM12 20c-.84-1.07-1.44-2.64-1.64-4.47h3.28c-.2 1.83-.8 3.4-1.64 4.47zm1.86-.82c.57-.91 1.02-1.99 1.33-3.18h2.79c.42 1.6-1.09 2.9-4.12 3.18zM16.12 16c.09-.98.14-1.98.14-3s-.05-2.02-.14-3h3.45a8.056 8.056 0 0 1 0 6h-3.45z"/></svg>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 small">Live Websites</p>
                                    <h4 class="fw-bold mb-0 counter-num text-sucess" data-target="{{ getLiveWebsites() }}">0</h4>
                                    <small style="font-size:11px;"><a href="{{ route('connectedwebsites') }}?status=live" class="text-primary text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></small>
                                </div>
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-success pulse-badge pulse-badge-success align-self-start" style="font-size:11px;">Live</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card stat-card shadow-sm h-100" style="border-left: 4px solid #f59e0b;">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-warning bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24" fill="#f59e0b">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                    </svg>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 small">Temporary Down Websites</p>
                                    <h4 class="fw-bold mb-0 counter-num text-warning" data-target="{{ $tempDownCount }}">0</h4>
                                    <small style="font-size:11px;"><a href="{{ route('connectedwebsites') }}?status=tdown" class="text-warning text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></small>
                                </div>
                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning pulse-badge pulse-badge-amber align-self-start" style="font-size:11px;">Down</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card stat-card shadow-sm h-100" style="border-left: 4px solid #ef4444;">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-danger bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24" fill="#ef4444">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                    </svg>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 small">Permanent Down Websites</p>
                                    <h4 class="fw-bold mb-0 counter-num text-danger" data-target="{{ $permDownCount }}">0</h4>
                                    <small style="font-size:11px;"><a href="{{ route('connectedwebsites') }}?status=pdown" class="text-danger text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></small>
                                </div>
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger pulse-badge pulse-badge-red align-self-start" style="font-size:11px;">Down</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-warning bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24"><g><rect fill="none" height="24" width="24"/><g><path fill="#f59e0b" d="M20,6h-3V4c0-1.1-0.9-2-2-2h-6C7.9,2,7,2.9,7,4v2H4C2.9,6,2,6.9,2,8v12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V8C22,6.9,21.1,6,20,6z M9,4h6v2H9V4z M20,20H4V8h16V20z"/></g></g></svg>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 small">Business Models</p>
                                    <h4 class="fw-bold mb-0 counter-num text-warning" data-target="{{ getModelsCount() }}">0</h4>
                                    <small style="font-size:11px;"><a href="{{ route('businessmodels') }}" class="text-warning text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></small>
                                </div>
                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning pulse-badge pulse-badge-amber align-self-start" style="font-size:11px;">Models</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-success bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24"><g><rect fill="none" height="24" width="24"/><g><path fill="#10b981" d="M17,3H7C5.9,3,5,3.9,5,5v16l2-1.5L9,21l2-1.5L13,21l2-1.5L17,21l2-1.5l2,1.5V5C21,3.9,20.1,3,19,3H17z M17,9H7V7h10V9z M17,13H7v-2h10V13z M13,17H7v-2h6V17z"/></g></g></svg>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 small">Invoices Created</p>
                                    <h4 class="fw-bold mb-0 counter-num text-success" data-target="{{ invoiceCount() }}">0</h4>
                                    <small style="font-size:11px;"><a href="#listinvoices" class="text-success text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></small>
                                </div>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success pulse-badge pulse-badge-green align-self-start" style="font-size:11px;">Invoices</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-danger bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 640 512" fill="#ef4444"><path d="M96 128a80 80 0 1 0 160 0A80 80 0 1 0 96 128zm224 0a80 80 0 1 0 160 0A80 80 0 1 0 320 128zM32 384c0-53 43-96 96-96h64c53 0 96 43 96 96v16c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16v-16zm288 0c0-35.3 28.7-64 64-64h96c35.3 0 64 28.7 64 64v32c0 8.8-7.2 16-16 16H336c-8.8 0-16-7.2-16-16v-32z"/></svg>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 small">Admin & Staff Users</p>
                                    <h4 class="fw-bold mb-0 counter-num text-danger" data-target="{{ userCount() }}">0</h4>
                                    <small style="font-size:11px;"><a href="{{ route('users.index') }}" class="text-danger text-decoration-none">View all <i class="bi bi-arrow-right"></i></a></small>
                                </div>
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger pulse-badge pulse-badge-red align-self-start" style="font-size:11px;">Users</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Row 3: Admin/Personal Stats (visible to admin & developer only) --}}
                @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'developer'))
                <div class="row row-sm g-3 mt-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card admin-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24" fill="#6366f1"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.93 6h-3.02c-.2-1.73-.8-3.3-1.64-4.47C16.37 4.28 18.05 5.87 17.93 8zM12 4.04c.84 1.07 1.44 2.64 1.64 4.47h-3.28c.2-1.83.8-3.4 1.64-4.47zM6.07 8c.12-2.13 1.8-3.72 3.66-4.47C8.8 4.7 8.2 6.27 8 8H6.07zM4.43 10h3.45c-.09.98-.14 1.98-.14 3s.05 2.02.14 3H4.43a8.056 8.056 0 0 1 0-6zm1.64 8h2.79c.31 1.19.76 2.27 1.33 3.18C7.16 20.9 5.65 19.6 6.07 18zM12 20c-.84-1.07-1.44-2.64-1.64-4.47h3.28c-.2 1.83-.8 3.4-1.64 4.47zm1.86-.82c.57-.91 1.02-1.99 1.33-3.18h2.79c.42 1.6-1.09 2.9-4.12 3.18zM16.12 16c.09-.98.14-1.98.14-3s-.05-2.02-.14-3h3.45a8.056 8.056 0 0 1 0 6h-3.45z"/></svg>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Websites</p>
                                    <h5 class="fw-bold mb-0 counter-num" data-target="{{ getAllWebsites() }}">0</h5>
                                    <small class="text-muted" style="font-size:11px;">Available Webistes</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card admin-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 24 24" fill="#6366f1"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.93 6h-3.02c-.2-1.73-.8-3.3-1.64-4.47C16.37 4.28 18.05 5.87 17.93 8zM12 4.04c.84 1.07 1.44 2.64 1.64 4.47h-3.28c.2-1.83.8-3.4 1.64-4.47zM6.07 8c.12-2.13 1.8-3.72 3.66-4.47C8.8 4.7 8.2 6.27 8 8H6.07zM4.43 10h3.45c-.09.98-.14 1.98-.14 3s.05 2.02.14 3H4.43a8.056 8.056 0 0 1 0-6zm1.64 8h2.79c.31 1.19.76 2.27 1.33 3.18C7.16 20.9 5.65 19.6 6.07 18zM12 20c-.84-1.07-1.44-2.64-1.64-4.47h3.28c-.2 1.83-.8 3.4-1.64 4.47zm1.86-.82c.57-.91 1.02-1.99 1.33-3.18h2.79c.42 1.6-1.09 2.9-4.12 3.18zM16.12 16c.09-.98.14-1.98.14-3s-.05-2.02-.14-3h3.45a8.056 8.056 0 0 1 0 6h-3.45z"/></svg>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Websites</p>
                                    <h5 class="fw-bold mb-0 counter-num" data-target="{{ mywebsites() }}">0</h5>
                                    <small class="text-muted" style="font-size:11px;">Added by you</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card admin-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-success bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" fill="#10b981" viewBox="0 0 24 24"><path d="M17,3H7C5.9,3,5,3.9,5,5v16l2-1.5L9,21l2-1.5L13,21l2-1.5L17,21l2-1.5l2,1.5V5C21,3.9,20.1,3,19,3H17z M17,9H7V7h10V9z M17,13H7v-2h10V13z M13,17H7v-2h6V17z"/></svg>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Invoices</p>
                                    <h5 class="fw-bold mb-0 counter-num" data-target="{{ myinvoices() }}">0</h5>
                                    <small class="text-muted" style="font-size:11px;">Created by you</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card admin-card shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="icon-box bg-warning bg-opacity-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" fill="#f59e0b" viewBox="0 0 24 24"><path d="M12 7v5l3 3-.75.75L11 13V7h1zm0-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Logged In Since</p>
                                    <h5 class="fw-bold mb-0" id="lastLoginTimer" data-last-login="{{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->toIso8601String() }}">Loading...</h5>
                                    <small class="text-muted" style="font-size:11px;">Time elapsed</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Charts & Table --}}
                <div class="row mt-3">

                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="card chart-card shadow-sm">
                            <div class="card-header border-0 p-4 pb-0">
                                <h5 class="fw-bold mb-1">Invoice Generation & Price Changes</h5>
                                <p class="text-muted mb-0" style="font-size:13px;">Invoices created (red) and price changes (blue) over the last 8 days.</p>
                            </div>
                            <div class="card-body p-4">
                                <div id="invoicechart"></div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'developer'))
                    <div class="col-sm-12 col-lg-12 col-xl-12 mt-3">
                        <div class="card chart-card shadow-sm">
                            <div class="card-header border-0 p-4 pb-0">
                                <h5 class="fw-bold mb-1">User-wise Invoice Generation</h5>
                                <p class="text-muted mb-0" style="font-size:13px;">How many invoices each user created over the last 8 days.</p>
                            </div>
                            <div class="card-body p-4">
                                <div id="userInvoiceChart"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-lg-12 mt-3" id="listinvoices">
                        <div class="card chart-card shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Invoice Generation History</h5>
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
                                                            {{ $invoice->website->site_name }}
                                                            <a href="{{ $invoice->website->site_link }}" target="_blank"><i class="bi bi-box-arrow-up-right ms-1"></i></a>
                                                        @elseif ($invoice->website && $invoice->website->site_name)
                                                            {{ $invoice->website->site_name }}
                                                            <a href="https://www.google.com/search?q={{ urlencode($invoice->website->site_name) }}" target="_blank" data-bs-toggle="tooltip" title="Model: {{ $invoice->model_type }}"><i class="bi bi-box-arrow-up-right ms-1"></i></a>
                                                        @else
                                                            <span class="text-muted">Site not found or deleted</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $invoice->currency }}{{ number_format($invoice->discount_amount, 2) }}</td>
                                                    <td class="text-center">{{ $invoice->currency }}{{ number_format($invoice->invoice_amount, 2) }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('product.selection', ['invoice_id' => $invoice->id]) }}" class="btn btn-outline-warning rounded-pill btn-sm" data-bs-toggle="tooltip" title="Regenerate the invoice with the same invoice number and amount.">
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
                                                                <img src="{{ asset($img) }}" alt="Profile" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                                            @else
                                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width:30px;height:30px;font-size:14px;" data-bs-toggle="tooltip" title="{{ $user->name }}">{{ strtoupper($user->name[0]) }}</div>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('uploads/profile/default-profile.png') }}" alt="Guest" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;" data-bs-toggle="tooltip" title="Guest">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $invoice->created_at->setTimezone('Asia/Kolkata')->format('d-m-Y h:i A') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

<div class="modal fade" id="generateReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-semibold" id="generateReportModalLabel">🧾 Invoice Report Generator</h5>
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
                                    <option value="{{ $model->id }}" {{ request()->business_model_id == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="site_id" class="form-label fw-medium">Select Websites</label>
                            <select name="site_id" id="site_id" class="form-select shadow-sm">
                                <option value="all" {{ request()->site_id == 'all' ? 'selected' : '' }}>All Sites</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}" {{ request()->site_id == $site->id ? 'selected' : '' }}>{{ $site->site_name }}</option>
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
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-bar-chart-line-fill me-2"></i>View Report</button>
                    <a href="{{ route('invoice.report', ['generate_pdf' => true, 'business_model_id' => request()->business_model_id, 'site_id' => request()->site_id, 'start_date' => request()->start_date, 'end_date' => request()->end_date]) }}" class="btn btn-danger px-4"><i class="bi bi-file-earmark-arrow-down-fill me-2"></i>Download as PDF</a>
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

        document.querySelectorAll('.counter-num').forEach(function (el) {
            const target = parseInt(el.getAttribute('data-target')) || 0;
            if (target === 0) { el.textContent = '0'; return; }
            const duration = 1200;
            const step = Math.ceil(duration / target);
            let current = 0;
            const timer = setInterval(function () {
                current += Math.ceil(target / 60);
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = current.toLocaleString();
            }, step);
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

    var options = {
        chart: {
            height: 350,
            zoom: { enabled: true },
            toolbar: {
                show: true,
                tools: { download: true, selection: true, zoom: true, zoomin: true, zoomout: true, pan: true, reset: true, customIcons: [] }
            },
            offsetX: 0,
            offsetY: 0
        },
        series: [
            { name: "Invoices Created Count", type: chartType, data: invoiceCounts, color: "#FF5733" },
            { name: "Price Changes Count", type: chartType, data: priceChangeCounts, color: "#1E90FF" }
        ],
        xaxis: { categories: invoiceDates, title: { text: 'Date' } },
        yaxis: { title: { text: 'Invoice Count' }, min: 0, labels: { style: { colors: '#666', fontSize: '12px' } } },
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
        chart: { type: 'area', height: 350 },
        series: @json($userInvoices),
        xaxis: { categories: @json($invoicedates), title: { text: 'Date' }, labels: { rotate: -45 } },
        yaxis: { title: { text: 'Invoice Count' } },
        stroke: { curve: 'smooth' },
        dataLabels: { enabled: true },
        tooltip: { shared: true },
        colors: ['#00b3ff','#28a745','#ffc107','#6610f2','#17a2b8','#e83e8c','#fd7e14','#6c757d','#20c997','#dc3545','#343a40','#198754','#0dcaf0','#ff5733','#8e44ad']
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
            buttons: ['csv', 'excel', 'pdf']
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
        if (!lastLogin) { el.textContent = 'Never'; return; }
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