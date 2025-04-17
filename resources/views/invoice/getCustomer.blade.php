@extends('layouts.app')

@section('title', ' Incoice Creation | Central Invoice System')

@section('content')
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('customerdetails.store') }}" id="getCustomerForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Selected Website <span class="text-danger">*</span>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#sitechangemodel" class="btn btn-sm btn-outline-primary ms-2">
                                                Change Site
                                            </a>
                                        </label>
                                        <input type="text" class="form-control" name="site_name" id="site_name" value="{{ $site->site_name ?? 'N/A' }}" readonly autocomplete="off">
                                        <input type="hidden" name="hidden_site_id" id="hidden_site_id" value="{{ $site->id ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" placeholder="Enter Customer Name" value="{{ $customer['customer_name'] ?? '' }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                        <input type="date" name="invoice_date" class="form-control" value="{{ $invoice['invoice_date'] ?? '' }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="invoice_amount" class="form-control" value="{{ $invoice['invoice_amount'] ?? '' }}"  placeholder="Enter invoice target amount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Email</label>
                                        <input type="email" name="customer_email" class="form-control" placeholder="Enter Customer Email (optional)">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Mobile</label>
                                        <input type="number" name="customer_mobile" class="form-control" placeholder="Enter Customer Mobile (optional)">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Mobile</label>
                                        <input type="text" name="company_mobile" class="form-control" placeholder="Enter Company Mobile" readonly value="{{ $site->company_mobile ?? '' }}">
                                    </div>
                                   
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Email</label>
                                        <input type="email" name="company_email" class="form-control" placeholder="Enter Company Email" readonly value="{{ $site->company_email ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Address</label>
                                        <input type="text" name="company_address" class="form-control" placeholder="Enter Company Address" readonly value="{{ $site->company_address ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Website</label>
                                        <input type="url" name="site_link" class="form-control" placeholder="Enter Site URL" value="{{ $site->site_link ?? '' }}">
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Proceed to Products Selection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    </div>

    <div class="modal fade" id="sitechangemodel" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Select a Different Site</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('site.connect.db', ['site_id' => request('site_id')]) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="site_id" class="form-label">Choose a site</label>
                            <select name="site_id" id="site_id" class="form-select select2" required>
                                <option value="">-- Select Site --</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s->id }}">{{ $s->site_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <p class="text-muted small">Selecting another site will refresh the page to re-establish the database connection.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Site</button>
                    </div>
                </form>
            </div>
        </div>
   </div>
@endsection

@push('scripts')
<script>
    document.getElementById('getCustomerForm').addEventListener('submit', function () {
        Swal.fire({
            title: 'Setting Things Up...',
            html: `
                <div class="d-flex flex-column align-items-center">
                    <div class="spinner-border text-primary" role="status"></div>
                    <small class="mt-2">Initializing connection, syncing data, and getting things ready..."</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>
 <script>
    $('#sitechangemodel').on('shown.bs.modal', function () {
        $('#site_id').select2({
            dropdownParent: $('#sitechangemodel'),
            placeholder: "-- Select Site --",
            allowClear: true,
            width: '100%'
        });
       
    });
</script>
@endpush