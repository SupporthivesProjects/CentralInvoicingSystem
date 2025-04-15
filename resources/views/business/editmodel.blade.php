@extends('layouts.app')

@section('title', 'Edit Model | Central Invoice System')

@section('content')
 

    <div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage Site</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">business model</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit business model</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Centered Form Row -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                        <form action="{{ route('businessmodel.update', $businessmodel->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                                <div class="mb-3">
                                    <label class="form-label">Business Model Name <span style="color:red">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Business Model Name" value="{{ $businessmodel->name}}"  required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Business Type <span style="color:red">*</span></label>
                                    <input type="text" name="model_type" class="form-control" placeholder="Enter Model type" value="{{ $businessmodel->model_type}}"  required>
                                    <small class="form-text text-muted">
                                        Use only lowercase letters and underscores (no spaces or capital letters).
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Icon Class <span style="color:red">*</span></label>
                                    <input type="text" name="icon_class" class="form-control" placeholder="e.g., fe fe-shopping-cart"  value="{{ $businessmodel->icon_class}}"  required>
                                    <small class="form-text text-muted">Use icon class like <code>fe fe-shopping-cart</code>, <code>fe fe-globe</code>, etc.</small>
                                </div>

                                <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('businessmodels') }}" class="btn btn-secondary">Cancel</a>
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
@endpush