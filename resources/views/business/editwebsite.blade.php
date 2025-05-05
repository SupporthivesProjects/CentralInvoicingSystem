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
                    <form d="editwebsite-form" method="POST" action="{{ route('website.update', $website->id) }}" enctype="multipart/form-data" class="row g-3 mt-0">
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
                                    value="{{ $website->db_password }}">
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
                                <label class="form-label">Technology <span style="color:red">*</span></label>
                                <select name="technology" class="form-select" required>
                                    <option selected disabled>Choose Technology</option>
                                    <option value="wordpress" {{ $website->technology == 'wordpress' ? 'selected' : '' }}>WordPress</option>
                                    <option value="laravel" {{ $website->technology == 'laravel' ? 'selected' : '' }}>Laravel</option>
                                    <option value="corephp" {{ $website->technology == 'corephp' ? 'selected' : '' }}>Core PHP</option>
                                </select>
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
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $website->bank_name) }}"  placeholder="Enter Bank Name">
                            </div>

                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Bank Code</label>
                                <input type="text" name="bank_code" class="form-control" value="{{ old('bank_code', $website->bank_code) }}"  placeholder="Enter Bank Code (e.g., IFSC or SWIFT)">
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
<script>
    document.getElementById('editwebsite-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Updating Website...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3">Hold tight! Your website details are being updated right now.</small>
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


@endpush