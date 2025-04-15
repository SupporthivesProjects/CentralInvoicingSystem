@extends('layouts.app')

@section('title', 'Edit Website | Central Invoice System')

@section('content')
   
    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage Sites</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Websites</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Website</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Form -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    <form method="POST" action="{{ route('website.update', $website->id) }}" enctype="multipart/form-data" class="row g-3 mt-0">
                            @csrf
                            @method('PATCH')

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Business Model <span style="color:red">*</span></label>
                                <select name="business_model_id" class="form-select" required>
                                    <option disabled {{ old('business_model_id', $website->business_model_id) ? '' : 'selected' }}>Choose Business Model</option>
                                    @foreach ($businessModels as $model)
                                        <option value="{{ $model->id }}" {{ old('business_model_id', $website->business_model_id) == $model->id ? 'selected' : '' }}>
                                            {{ $model->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Name <span style="color:red">*</span></label>
                                <input type="text" name="site_name" class="form-control" required placeholder="Enter Site Name"
                                    value="{{ old('site_name', $website->site_name) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Host <span style="color:red">*</span></label>
                                <input type="text" name="db_host" class="form-control" placeholder="Enter Database Host" required
                                    value="{{ old('db_host', $website->db_host) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Port <span style="color:red">*</span></label>
                                <input type="text" name="db_port" class="form-control" placeholder="Enter Database Port" required
                                    value="{{ old('db_port', $website->db_port ?? '3306') }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Name <span style="color:red">*</span></label>
                                <input type="text" name="db_name" class="form-control" placeholder="Enter Database Name" required
                                    value="{{ old('db_name', $website->db_name) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Username <span style="color:red">*</span></label>
                                <input type="text" name="db_username" class="form-control" placeholder="Enter Database Username" required
                                    value="{{ old('db_username', $website->db_username) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Password <span style="color:red">*</span></label>
                                <input type="text" name="db_password" class="form-control" placeholder="Enter Database Password" required
                                    value="{{ old('db_password', $website->db_password) }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Website Link <span style="color:red">*</span></label>
                                <input type="text" name="site_link" class="form-control" placeholder="Enter Website link"
                                    value="{{ old('site_link', $website->site_link) }}">
                            </div>
                        
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Description</label>
                                <input type="text" name="site_description" class="form-control" placeholder="Enter Site Description (optional)"
                                    value="{{ old('site_description', $website->site_description) }}">
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Remark</label>
                                <input type="text" name="remark" class="form-control" placeholder="Enter Remark here in case"
                                    value="{{ old('remark', $website->remark) }}">
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $website->company_name) }}"  placeholder="Enter Company Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Email</label>
                                <input type="email" name="company_email" class="form-control" value="{{ old('company_email', $website->company_email) }}" placeholder="Enter Company Email">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Mobile</label>
                                <input type="text" name="company_mobile" class="form-control" value="{{ old('company_mobile', $website->company_mobile) }}" placeholder="Enter Company Mobile">
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Address</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address', $website->company_address) }}" placeholder="Enter Company Address">
                            </div>
                            <hr>
                           <!-- First Row for Invoice Template -->
                            <div class="row mb-4">
                                <div class="col-md-6 mx-auto">
                                    <label class="form-label">Invoice Template (HTML/HTM/PHP)</label>
                                    <input type="file" name="invoice_template" class="form-control" accept=".html,.htm,.php">
                                    @if ($website->invoice_template)
                                        <small class="text-muted">Current: <a href="{{ asset($website->invoice_template) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->invoice_template) }}</a></small>
                                    @endif
                                </div>
                            </div>

                            <!-- Second Row for Logo, Header, and Footer -->
                            <div class="row mb-4 mt-1">
                                <!-- Company Logo -->
                                <div class="col-md-4 mx-auto">
                                    <label class="form-label">Company Logo</label>
                                    <input type="file" name="company_logo" class="form-control" accept=".jpeg,.png,.jpg">
                                    @if ($website->company_logo)
                                        <small class="text-muted">Current: <a href="{{ asset($website->company_logo) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->company_logo) }}</a></small>
                                    @endif
                                </div>

                                <!-- Invoice Header Image -->
                                <div class="col-md-4 mx-auto">
                                    <label class="form-label">Invoice Header Image</label>
                                    <input type="file" name="invoice_header_image" class="form-control" accept=".jpeg,.png,.jpg">
                                    @if ($website->invoice_header_image)
                                        <small class="text-muted">Current: <a href="{{ asset($website->invoice_header_image) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->invoice_header_image) }}</a></small>
                                    @endif
                                </div>

                                <!-- Invoice Footer Image -->
                                <div class="col-md-4 mx-auto">
                                    <label class="form-label">Invoice Footer Image</label>
                                    <input type="file" name="invoice_footer_image" class="form-control" accept=".jpeg,.png,.jpg">
                                    @if ($website->invoice_footer_image)
                                        <small class="text-muted">Current: <a href="{{ asset($website->invoice_footer_image) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->invoice_footer_image) }}</a></small>
                                    @endif
                                </div>
                            </div>

                            <!-- Third Row for Invoice Image 1, Image 2, Image 3 -->
                            <div class="row mb-4">
                                <!-- Invoice Image 1 -->
                                <div class="col-md-4 mx-auto">
                                    <label class="form-label">Invoice Image 1</label>
                                    <input type="file" name="invoice_image1" class="form-control" accept=".jpeg,.png,.jpg">
                                    @if ($website->invoice_image1)
                                        <small class="text-muted">Current: <a href="{{ asset($website->invoice_image1) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->invoice_image1) }}</a></small>
                                    @endif
                                </div>

                                <!-- Invoice Image 2 -->
                                <div class="col-md-4 mx-auto">
                                    <label class="form-label">Invoice Image 2</label>
                                    <input type="file" name="invoice_image2" class="form-control" accept=".jpeg,.png,.jpg">
                                    @if ($website->invoice_image2)
                                        <small class="text-muted">Current: <a href="{{ asset($website->invoice_image2) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->invoice_image2) }}</a></small>
                                    @endif
                                </div>

                                <!-- Invoice Image 3 -->
                                <div class="col-md-4 mx-auto">
                                    <label class="form-label">Invoice Image 3</label>
                                    <input type="file" name="invoice_image3" class="form-control" accept=".jpeg,.png,.jpg">
                                    @if ($website->invoice_image3)
                                        <small class="text-muted">Current: <a href="{{ asset($website->invoice_image3) }}" target="_blank" rel="noopener noreferrer"> {{ basename($website->invoice_image3) }}</a></small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary mt-2">Update Website</button>
                            </div>
                        </form>

                    </div>
                    <div class="card-footer d-none border-top-0"></div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
@endpush