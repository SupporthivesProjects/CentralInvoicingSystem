@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')

    <div class="main-content app-content">
            <div class="container-fluid">
                  <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage sites</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Connected Websites</li>
                    </ol>
                </div>
            </div>
            <!-- Page Header Close -->


                <!-- Start:: row-4 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title mb-0">Available Websites</div>
                                <a href="{{ route('website.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                    New Website
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Model</th>
                                                <th>Site Name</th>
                                                <th>Site live link</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($websites as $index => $site)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $site->businessModel->name ?? '-' }}</td>
                                                    <td>{{ $site->site_name }}</td>
                                                    <td><a href="{{ $site->site_link }}" target="_blank" >{{ $site->site_link }}</a></td>
                                                    <td>{{ $site->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                     
                                                        <a href="{{ route('site.connect.db', $site->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-file-invoice"></i> Generate Invoice
                                                        </a>
                                                        <a href="{{ route('website.edit', $site->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $site->id }}">
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
                        return fetch(`/website/${id}`, {
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