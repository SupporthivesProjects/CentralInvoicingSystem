@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')
    <div class="main-content app-content">
            <div class="container-fluid">
                  <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Business Models</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Models</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->


                <!-- Start:: row-4 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                          <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title mb-0">Business Models</div>
                                <a href="{{ route('businessmodel.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                    New Model
                                </a>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Model</th>
                                                <th>Model Type</th>
                                                <th>Model Icon</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($businessModels as $index => $model)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $model->name ?? '-' }}</td>
                                                    <td>{{ $model->model_type ?? '-' }}</td>
                                                    <td> <i class="{{ !empty($model->icon_class) ? $model->icon_class : 'ti-wallet' }}  side-menu__icon"></i></td>
                                                    <td>{{ $model->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                    <a href="{{ route('businessmodel.websites', $model->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-globe"></i> View sites ({{ count($model->websites) }})
                                                    </a>
                                                        <a href="{{ route('businessmodel.edit', $model->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $model->id }}">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End:: row-4 -->
            </div>
        </div>
    

    
@endsection
@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/businessmodel/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Delete failed: ${error}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value?.success) {
                toastr.success(result.value.message || "Deleted successfully!");
                setTimeout(() => {
                    location.reload(); // Optional: reload if needed
                }, 1500);
            } else if (result.value && !result.value.success) {
                toastr.error(result.value.message || "Failed to delete!");
            }
        });
    });
</script>
@endpush