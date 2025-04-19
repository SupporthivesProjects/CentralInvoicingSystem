@extends('layouts.app')

@section('title', ' Incoice Creation | Central Invoice System')

@section('content')
    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="mb-3 mt-3">
                <h2 class="main-content-title fs-24 mb-3">Enter Customer and Invoice Details</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-store"></i>  Select Site
                    </li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-primary"> Customer and Invoice Details</a></li>
                </ol>
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
                                    <!-- Site Name with Prefix and Refresh Icon -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Selected Website</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            <input type="text" class="form-control" name="site_name" id="site_name" value="{{ $site->site_name ?? 'N/A' }}" readonly autocomplete="off">
                                            <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#sitechangemodel"><i class="fas fa-sync-alt text-primary" style="cursor: pointer;"></i></span>
                                            <input type="hidden" name="hidden_site_id" id="hidden_site_id" value="{{ $site->id ?? '' }}">
                                        </div>
                                    </div>

                                    <!-- Model Type -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Model Type</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                            <input type="text" class="form-control" name="model_type" value="{{ $site->businessmodel->name ?? '' }}" readonly>
                                            <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white text-primary" title="Edit Site Info">
                                                <i class="fas fa-sync-alt"></i> 
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Technology -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Technology</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                                            <input type="text" name="technology" class="form-control" placeholder="e.g. Laravel" value="{{ $site->technology ?? '' }}" readonly required>
                                            <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white text-primary" title="Edit Site Info">
                                                <i class="fas fa-sync-alt"></i> 
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Customer Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="customer_name" class="form-control" placeholder="Enter Customer Name" value="{{ $customer['customer_name'] ?? '' }}" required>
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span> 
                                        </div>
                                    </div>

                                    <!-- Invoice Date -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="invoice_date" class="form-control" value="{{ $invoice['invoice_date'] ?? '' }}" required>
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span> 
                                        </div>
                                    </div>

                                    <!-- Invoice Amount -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Invoice Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="invoice_amount" class="form-control" placeholder="Enter invoice target amount" value="{{ $invoice['invoice_amount'] ?? '' }}" required>
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span> 
                                        </div>
                                    </div>

                                    <!-- Customer Email -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="customer_email" class="form-control" placeholder="Enter Customer Email (optional)">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span> 
                                        </div>
                                    </div>

                                    <!-- Customer Mobile -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Customer Mobile</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                            <input type="number" name="customer_mobile" class="form-control" placeholder="Enter Customer Mobile (optional)">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span> 
                                        </div>
                                    </div>

                                    <!-- Company Mobile -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Mobile</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                            <input type="text" name="company_mobile" class="form-control" readonly value="{{ $site->company_mobile ?? '' }}">
                                            <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white text-primary" title="Edit Site Info">
                                                <i class="fas fa-sync-alt"></i> 
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Company Email -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                                            <input type="email" name="company_email" class="form-control" readonly value="{{ $site->company_email ?? '' }}">
                                            <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white text-primary" title="Edit Site Info">
                                                <i class="fas fa-sync-alt"></i> 
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Company Address -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" name="company_address" class="form-control" readonly value="{{ $site->company_address ?? '' }}">
                                            <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white text-primary" title="Edit Site Info">
                                                <i class="fas fa-sync-alt"></i> 
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Company Website -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Website</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                            <input type="url" name="site_link" class="form-control" readonly placeholder="Enter Site URL" value="{{ $site->site_link ?? '' }}">
                                            <a href="{{ route('website.edit', ['id' => $site->id]) }}" class="input-group-text bg-white text-primary" title="Edit Site Info">
                                                <i class="fas fa-sync-alt"></i> 
                                            </a>
                                        </div>
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