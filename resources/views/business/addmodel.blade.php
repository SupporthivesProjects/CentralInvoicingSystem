@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')
<div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage Site</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Add New business model</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Enter model details</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Centered Form Row -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                        <form method="POST" id="addbusinessmodel-form" action="{{ route('businessmodel.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Business Model Name <span style="color:red">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Business Model Name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Business Type <span style="color:red">*</span></label>
                                    <input type="text" name="model_type" class="form-control" placeholder="Enter Model type" required>
                                    <small class="form-text text-muted">
                                        Use only lowercase letters and underscores (no spaces or capital letters).
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Icon Class <span style="color:red">*</span></label>
                                    <input type="text" name="icon_class" class="form-control" placeholder="e.g., fe fe-shopping-cart" required>
                                    <small class="form-text text-muted">Use icon class like <code>fe fe-shopping-cart</code>, <code>fe fe-globe</code>, etc.</small>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Add Business Model</button>
                                </div>
                            </form>

                        </div>
                        <div class="card-footer d-none border-top-0">
                            <!-- Optional Code Section -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.getElementById('addbusinessmodel-form').addEventListener('submit', function () {
        Swal.fire({
            title: 'Adding your business model...',
            html: `
                <div class="d-flex flex-column align-items-center">
                     <div class="loaderBar"></div>
                    <small class="mt-3 fs-6">Hold tight! Your business model is being added right now.</small>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });
</script>
@endpush