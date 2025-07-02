@extends('layouts.app')

@section('title', 'Edit Website | Central Invoice System')

@section('content')
   
    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Edit Website</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">Models & Websites</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Website</li>
                    </ol>
                </div>

                <div class="mt-3 mt-md-0">
                    <button type="button" id="check-remote-db" class="btn btn-outline-warning">
                        Check DB Connectivity
                    </button>
                    <a  href="{{ route('site.connect.db', $website->id) }}" class="btn btn-outline-success">
                        Generate Invoice
                    </a>
                   
                </div>
            </div>
            <div class="col-xl-12">
                <div id="db-status-wrapper" class="text-center mt-3 mb-3">
                    <div id="db-status-message" style="display: none;"></div>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Form -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    <form id="editwebsite-form" method="POST" action="{{ route('website.update', $website->id) }}" enctype="multipart/form-data" class="row g-3 mt-0">
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
                                <label class="form-label">Technology Stack <span style="color:red">*</span></label>
                                <select name="technology" class="form-select" required>
                                    <option value="wordpress" {{ $website->technology == 'wordpress' ? 'selected' : '' }}>WordPress</option>
                                    <option value="laravel" {{ $website->technology == 'laravel' ? 'selected' : '' }}>Laravel</option>
                                    <option value="corephp" {{ $website->technology == 'corephp' ? 'selected' : '' }}>Core PHP</option>
                                </select>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Host <span style="color:red">*</span></label>
                                <input type="text" name="db_host" id="db_host" class="form-control" placeholder="Enter Database Host" required
                                    value="{{ $website->db_host }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Port <span style="color:red">*</span></label>
                                <input type="text" name="db_port" id="db_port" class="form-control" placeholder="Enter Database Port" required
                                    value="{{ $website->db_port }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Name <span style="color:red">*</span></label>
                                <input type="text" name="db_name" id="db_name" class="form-control" placeholder="Enter Database Name" required
                                    value="{{ $website->db_name }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Username <span style="color:red">*</span></label>
                                <input type="text" name="db_username" id="db_username" class="form-control" placeholder="Enter Database Username" required
                                    value="{{ $website->db_username }}">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Database Password <span style="color:red">*</span></label>
                                <input type="text" name="db_password" id="db_password"  class="form-control" placeholder="Enter Database Password" required
                                    value="{{ $website->db_password }}" >
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Website Link <span style="color:red">*</span></label>
                                <input type="text" name="site_link" class="form-control" placeholder="Enter Website link"
                                    value="{{ old('site_link', $website->site_link) }}" required>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Name <span style="color:red">*</span></label>
                                <input type="text" name="site_name" class="form-control" required placeholder="Enter Site Name"
                                    value="{{ old('site_name', $website->site_name) }}">
                            </div>
                           
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">PDF Size <span style="color:red">*</span></label>
                                <select name="pdf_size" class="form-select" required>
                                    @php
                                        $pdfSize = old('pdf_size', $website->pdf_size ?? 'A4');
                                    @endphp
                                    <option value="A4" {{ $pdfSize === 'A4' ? 'selected' : '' }}>A4</option>
                                    <option value="A5" {{ $pdfSize === 'A5' ? 'selected' : '' }}>A5</option>
                                    <option value="Letter" {{ $pdfSize === 'Letter' ? 'selected' : '' }}>Letter</option>
                                    <option value="Legal" {{ $pdfSize === 'Legal' ? 'selected' : '' }}>Legal</option>
                                </select>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">PDF Orientation <span style="color:red">*</span></label>
                                <select name="pdf_orientation" class="form-select" required>
                                    @php
                                        $orientation = old('pdf_orientation', $website->pdf_orientation ?? 'portrait');
                                    @endphp
                                    <option value="portrait" {{ $orientation === 'portrait' ? 'selected' : '' }}>Portrait</option>
                                    <option value="landscape" {{ $orientation === 'landscape' ? 'selected' : '' }}>Landscape</option>
                                </select>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Site Description</label>
                                <input type="text" name="site_description" class="form-control" placeholder="Enter Site Description (optional)"
                                    value="{{ old('site_description', $website->site_description) }}">
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
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $website->bank_name) }}"  placeholder="Enter Bank Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Bank Code</label>
                                <input type="text" name="bank_code" class="form-control" value="{{ old('bank_code', $website->bank_code) }}"  placeholder="Enter Bank Code (e.g., IFSC or SWIFT)">
                            </div>
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Company Address</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address', $website->company_address) }}" placeholder="Enter Company Address">
                            </div>

                            <div class="accordion w-100" id="websiteTableAccordion">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="tableConfigHeading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tableConfigCollapse">
                                            Website Table Configuration
                                        </button>
                                    </h2>
                                    <div id="tableConfigCollapse" class="accordion-collapse collapse" data-bs-parent="#websiteTableAccordion">
                                        <div class="accordion-body">
                                            <div class="alert alert-warning mb-4" role="alert" style="font-size: 14px;">
                                                ⚠️ <strong>Warning:</strong> Please be careful when modifying table names. If the table is already in use and working, changing the name may break related features.
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Product Table Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="product_table" class="form-control" 
                                                        value="{{ old('product_table', $website->product_table) }}" placeholder="Enter Product Table Name" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Bundle Table Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="bundle_table" class="form-control" 
                                                        value="{{ old('bundle_table', $website->bundle_table) }}" placeholder="Enter Bundle Table Name" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">General Settings Table Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="general_settings" class="form-control" 
                                                        value="{{ old('general_settings', $website->general_settings) }}" placeholder="Enter General Settings Table Name" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Currency Table Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="currency_table" class="form-control" 
                                                        value="{{ old('currency_table', $website->currency_table) }}" placeholder="Enter Currency Table Name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Category Table Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="category_table" class="form-control" 
                                                        value="{{ old('category_table', $website->category_table) }}" placeholder="Enter Category Table Name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tags Table Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="tags_table" class="form-control" 
                                                        value="{{ old('tags_table', $website->tags_table) }}" placeholder="Enter Category and Product relational Table Name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> 
                            <div class="my-4">
                                <div class="d-flex align-items-center text-muted">
                                    <div class="flex-grow-1 border-bottom"></div>
                                    <div class="px-3 fw-semibold">Invoice Template/Images</div>
                                    <div class="flex-grow-1 border-bottom"></div>
                                </div>
                            </div>

                            <div class="row mb-4 mt-2">
                                <div class="col-md-6">
                                    <div class="p-4 border border-primary rounded-4 shadow-sm bg-white h-100">
                                        <h6 class="text-primary fw-bold mb-3">
                                            📄 Invoice Template (HTML/HTM/PHP)
                                        </h6>
                                        <input type="file" name="invoice_template" class="form-control" accept=".html,.htm,.php">
                                        @if ($website->invoice_template)
                                            <small class="text-muted d-block mt-2">
                                                Current:
                                                <a href="{{ asset($website->invoice_template) }}" target="_blank" rel="noopener noreferrer">
                                                    {{ basename($website->invoice_template) }}
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-4 border border-primary rounded-4 shadow-sm bg-white h-100">
                                        <h6 class="text-primary fw-bold mb-3">
                                            ✍️ Invoice Signature (Image)
                                        </h6>
                                        <input type="file" name="invoice_signature" class="form-control" accept=".jpeg,.png,.jpg">
                                        @if ($website->invoice_signature)
                                            <small class="text-muted d-block mt-2">
                                            invoice_signature:
                                                <a class="hover-preview-link"  data-img="{{ asset($website->invoice_signature) }}" href="{{ asset($website->invoice_signature) }}" target="_blank" rel="noopener noreferrer">
                                                    {{ basename($website->invoice_signature) }}
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            

                            <div class="container-fluid">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Logo</label>
                                            <input type="file" name="company_logo" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->company_logo)
                                                <small class="d-block text-muted mt-2">
                                                company_logo:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->company_logo) }}" href="{{ asset($website->company_logo) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->company_logo) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Header Image</label>
                                            <input type="file" name="invoice_header_image" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_header_image)
                                                <small class="d-block text-muted mt-2">
                                                invoice_header_image:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_header_image) }}" href="{{ asset($website->invoice_header_image) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_header_image) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Footer Image</label>
                                            <input type="file" name="invoice_footer_image" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_footer_image)
                                                <small class="d-block text-muted mt-2">
                                                invoice_footer_image:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_footer_image) }}" href="{{ asset($website->invoice_footer_image) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_footer_image) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 1</label>
                                            <input type="file" name="invoice_image1" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image1)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image1:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image1) }}" href="{{ asset($website->invoice_image1) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image1) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 2</label>
                                            <input type="file" name="invoice_image2" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image2)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image2:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image2) }}" href="{{ asset($website->invoice_image2) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image2) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 3</label>
                                            <input type="file" name="invoice_image3" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image3)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image3:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image3) }}" href="{{ asset($website->invoice_image3) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image3) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 4</label>
                                            <input type="file" name="invoice_image4" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image4)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image4:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image4) }}" href="{{ asset($website->invoice_image4) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image4) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 5</label>
                                            <input type="file" name="invoice_image5" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image5)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image5:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image5) }}" href="{{ asset($website->invoice_image5) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image5) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 6</label>
                                            <input type="file" name="invoice_image6" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image6)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image6:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image6) }}" href="{{ asset($website->invoice_image6) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image6) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 7</label>
                                            <input type="file" name="invoice_image7" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image7)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image7:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image7) }}" href="{{ asset($website->invoice_image7) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image7) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 8</label>
                                            <input type="file" name="invoice_image8" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image8)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image8:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image8) }}"  href="{{ asset($website->invoice_image8) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image8) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="p-3 border rounded-3 shadow-sm bg-white">
                                            <label class="form-label fw-semibold text-dark">Invoice Image 9</label>
                                            <input type="file" name="invoice_image9" class="form-control" accept=".jpeg,.png,.jpg">
                                            @if ($website->invoice_image9)
                                                <small class="d-block text-muted mt-2">
                                                invoice_image9:
                                                    <a class="hover-preview-link"  data-img="{{ asset($website->invoice_image9) }}" href="{{ asset($website->invoice_image9) }}" target="_blank" rel="noopener noreferrer">
                                                        {{ basename($website->invoice_image9) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <br>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-2">Update Website</button>
                                </div>
                            </div>

                            </form>

                    </div>
                    <div class="card-footer d-none border-top-0"></div>
                </div>
            </div>
          
           

        </div>
    </div>

   
    <div id="hoverPreviewBox" style="display: none;position: fixed;z-index: 9999; background: #fff;padding: 8px;border-radius: 8px;box-shadow: 0 0 10px rgba(0,0,0,0.3); max-width: 300px;max-height: 300px;pointer-events: none;">
        <img id="hoverPreviewImage" src="" alt="Preview" style="max-width: 100%; max-height: 250px;">
    </div>



@endsection
@push('scripts')
<script>
    document.getElementById('editwebsite-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Updating Website...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3 fs-6">Hold tight! Your website details are being updated right now.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#check-remote-db').click(function () {
            $('#db-status-message')
                .html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span><span>Establishing connection...</span>`)
                .css('color', '#6c757d')
                .fadeIn(300);
            $('.field-error').remove();

            var db_host = $('#db_host').val();
            var db_port = $('#db_port').val();
            var db_name = $('#db_name').val();
            var db_username = $('#db_username').val();
            var db_password = $('#db_password').val();
            
            if(!db_host){
                $('#db-status-message').html('<span class="field-error text-danger">Database Host is required</span>').fadeOut(1000);
                return;
            }
            if(!db_port){
                $('#db-status-message').html('<span class="field-error text-danger">Database Port is required</span>').fadeOut(1000);
                return;
            }
            if(!db_name){
                $('#db-status-message').html('<span class="field-error text-danger">Database Name is required</span>').fadeOut(1000);
                return;
            }
            if(!db_username){
                $('#db-status-message').html('<span class="field-error text-danger">Database Username is required</span>').fadeOut(1000);
                return;
            }
            if(!db_password){
                $('#db-status-message').html('<span class="field-error text-danger">Database Password is required</span>').fadeOut(1000);
                return;
            }

            $.ajax({
                url: "{{ route('check.db.connectivity') }}",
                type: 'POST',
                data: {
                    db_host: db_host,
                    db_port: db_port,
                    db_name: db_name,
                    db_username: db_username,
                    db_password: db_password,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $('#db-status-message').html(`
                            <div class="checkmark-wrapper">
                                <div class="checkmark-circle">
                                    <div class="checkmark"></div>
                                </div>
                                <div>Connection successful!</div>
                            </div>
                        `).fadeIn(500);
                    } else {
                        $('#db-status-message').html('<span class="text-danger">' + response.message + '</span>');
                    }
                    setTimeout(function () {
                        $('#db-status-message').fadeOut(500);
                    }, 5000);
                },
                error: function () {
                    $('#db-status-message').html('<span class="text-danger">Error occurred while connecting to the DB.</span>');
                    setTimeout(function () {
                        $('#db-status-message').fadeOut(500);
                    }, 5000);
                }
            });
        });
    });
</script>

<script>
$(document).ready(function () {
    const offsetX = 30; 
    const offsetY = 20; 

    $('.hover-preview-link').on('mouseenter', function (e) {
        const imgUrl = $(this).data('img');
        $('#hoverPreviewImage').attr('src', imgUrl);
        $('#hoverPreviewBox').fadeIn(150);
    });

    $('.hover-preview-link').on('mousemove', function (e) {
        $('#hoverPreviewBox').css({
            top: e.clientY + offsetY + 'px',
            left: e.clientX + offsetX + 'px'
        });
    });

    $('.hover-preview-link').on('mouseleave', function () {
        $('#hoverPreviewBox').fadeOut(100);
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-column').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const container = document.querySelector(targetId);
                const prefix = targetId.replace('#', '').replace('Columns', '');

                const newInput = document.createElement('div');
                newInput.className = 'input-group mb-2';
                newInput.innerHTML = `
                    <input type="text" name="${prefix}_columns[]" class="form-control" placeholder="Enter column name">
                    <button type="button" class="btn btn-danger remove-column">Remove</button>
                `;
                container.appendChild(newInput);
            });
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-column')) {
                e.target.closest('.input-group').remove();
            }
        });
    });
</script>

@endpush