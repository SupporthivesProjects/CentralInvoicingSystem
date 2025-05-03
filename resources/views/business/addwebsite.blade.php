@extends('layouts.app')

@section('title', 'Connect New Website | Central Invoice System')

@section('content')

    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Add New Website</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">Models & Websites</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Website</li>
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
                    <form method="POST" action="{{ route('website.store') }}" enctype="multipart/form-data" class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Business Model <span style="color:red">*</span></label>
                            <select name="business_model_id" class="form-select" required>
                                <option selected disabled>Choose Business Model</option>
                                @foreach ($businessModels as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Site Name <span style="color:red">*</span></label>
                            <input type="text" name="site_name" class="form-control" required placeholder="Enter Site Name">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Host <span style="color:red">*</span></label>
                            <input type="text" name="db_host" class="form-control" placeholder="Enter Database Host" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Port <span style="color:red">*</span></label>
                            <input type="text" name="db_port" class="form-control" placeholder="Enter Database Port" value="3306" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Name <span style="color:red">*</span></label>
                            <input type="text" name="db_name" class="form-control" placeholder="Enter Database Name" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Username <span style="color:red">*</span></label>
                            <input type="text" name="db_username" class="form-control" placeholder="Enter Database Username" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Database Password <span style="color:red">*</span></label>
                            <input type="text" name="db_password" class="form-control" placeholder="Enter Database Password" required>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Website Link <span style="color:red">*</span></label>
                            <input type="text" name="site_link" class="form-control" placeholder="Enter Website link">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Site Description</label>
                            <input type="text" name="site_description" class="form-control" placeholder="Enter Site Description (optional)">
                        </div>

                        <!-- Add the Technology Field Here -->
                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Technology <span style="color:red">*</span></label>
                            <select name="technology" class="form-select" required>
                                <option selected disabled>Choose Technology</option>
                                <option value="wordpress">WordPress</option>
                                <option value="laravel">Laravel</option>
                                <option value="corephp">Core PHP</option>
                            </select>
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="Enter Company Name">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Email</label>
                            <input type="email" name="company_email" class="form-control" placeholder="Enter Company Email">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Mobile</label>
                            <input type="text" name="company_mobile" class="form-control" placeholder="Enter Company Mobile">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Company Address</label>
                            <input type="text" name="company_address" class="form-control" placeholder="Enter Company Address">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name">
                        </div>

                        <div class="col-md-6 mx-auto">
                            <label class="form-label">Bank Code</label>
                            <input type="text" name="bank_code" class="form-control" placeholder="Enter Bank Code (e.g., IFSC or SWIFT)">
                        </div>

                        <hr>
                        <!-- First Row for Invoice Template -->
                        <div class="row mb-4 mt-1">
                            <div class="col-md-6 mx-auto">
                                <label class="form-label">Invoice Template (HTML/HTM/PHP)</label>
                                <input type="file" name="invoice_template" class="form-control" accept=".html,.htm,.php">
                            </div>
                        </div>

                        <!-- Second Row for Logo, Header, and Footer -->
                        <div class="row mb-4">
                            <!-- Company Logo -->
                            <div class="col-md-4 mx-auto">
                                <label class="form-label">Company Logo</label>
                                <input type="file" name="company_logo" class="form-control" accept=".jpeg,.png,.jpg">
                            </div>
                            
                            <!-- Invoice Header Image -->
                            <div class="col-md-4 mx-auto">
                                <label class="form-label">Invoice Header Image</label>
                                <input type="file" name="invoice_header_image" class="form-control" accept=".jpeg,.png,.jpg">
                            </div>
                            
                            <!-- Invoice Footer Image -->
                            <div class="col-md-4 mx-auto">
                                <label class="form-label">Invoice Footer Image</label>
                                <input type="file" name="invoice_footer_image" class="form-control" accept=".jpeg,.png,.jpg">
                            </div>
                        </div>

                        <!-- Third Row for Invoice Image 1, Image 2, Image 3 -->
                        <div class="row mb-4">
                            <!-- Invoice Image 1 -->
                            <div class="col-md-4 mx-auto">
                                <label class="form-label">Invoice Image 1</label>
                                <input type="file" name="invoice_image1" class="form-control" accept=".jpeg,.png,.jpg">
                            </div>

                            <!-- Invoice Image 2 -->
                            <div class="col-md-4 mx-auto">
                                <label class="form-label">Invoice Image 2</label>
                                <input type="file" name="invoice_image2" class="form-control" accept=".jpeg,.png,.jpg">
                            </div>

                            <!-- Invoice Image 3 -->
                            <div class="col-md-4 mx-auto">
                                <label class="form-label">Invoice Image 3</label>
                                <input type="file" name="invoice_image3" class="form-control" accept=".jpeg,.png,.jpg">
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary mt-2">Add Website</button>
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