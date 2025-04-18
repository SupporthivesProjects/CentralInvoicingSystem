@extends('layouts.app')

@section('title', 'Connect New Website | Central Invoice System')

@section('content')

    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage Sites</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Connect New Website</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Enter Details</li>
                    </ol>
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
                                <option value="django">Django</option>
                                <option value="corephp">Core PHP</option>
                                <option value="static">Static</option>
                                <option value="joomla">Joomla</option>
                                <option value="other">Other</option>
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
@endpush