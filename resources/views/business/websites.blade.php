@extends('layouts.app')

@section('title', 'Available Websites | Central Invoice System')

@section('content')

    <div class="main-content app-content">
            <div class="container-fluid">
                  <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Manage Websites</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Available Websites</li>
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
                                @if(auth()->user()->roles->contains('name', 'developer'))
                                    <a href="{{ route('website.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                    New Website
                                    </a>
                                @endif

                               
                              </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="websites-datatables" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Business Model</th>
                                            <th>Site Name</th>
                                            <th>Bank Name</th>
                                            <th>Bank Code</th>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>

                                        <tbody>
                                            @foreach ($websites as $index => $site)
                                                <tr>
                                                    <td>{{ $site->id }}</td>
                                                    <td data-bs-toggle="tooltip" title="{{ $site->technology }}">
                                                        {{ $site->businessModel->name ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $site->site_name }}
                                                        @if($site->site_link)
                                                            <a href="{{ $site->site_link }}" target="_blank">
                                                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control inline-edit" data-id="{{ $site->id }}" data-field="bank_name" value="{{ $site->bank_name }}">
                                                            <span class="input-group-text update-icon">
                                                            <i class="fas fa-edit"></i> 
                                                            </span>
                                                        </div>
                                                        </td>

                                                        <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control inline-edit" data-id="{{ $site->id }}" data-field="bank_code" value="{{ $site->bank_code }}">
                                                            <span class="input-group-text update-icon">
                                                            <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                    </td>
                                                   
                                                    <td class="text-center">
                                                        <button onclick="window.location.href='{{ route('site.connect.db', $site->id) }}'" class="btn btn-sm btn-warning" 
                                                            @if($site->site_status === 'pdown') disabled @endif>
                                                            <i class="fas fa-file-invoice"></i> Generate Invoice
                                                        </button>
                                                        @if(auth()->user()->roles->contains('name', 'admin'))
                                                            <a href="{{ route('website.edit', $site->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        @endif
                                                        @if(auth()->user()->roles->contains('name', 'developer'))
                                                            <a href="{{ route('website.edit', $site->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $site->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endif
                                                       
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $statusMap = [
                                                                'live' => ['class' => 'success', 'title' => 'Site is live'],
                                                                'tdown' => ['class' => 'warning', 'title' => 'Site is temporarily down'],
                                                                'pdown' => ['class' => 'danger', 'title' => 'Site is permanently down'],
                                                            ];
                                                        @endphp

                                                        <span class="badge bg-{{ $statusMap[$site->site_status]['class'] }}" data-bs-toggle="tooltip" title="{{ $statusMap[$site->site_status]['title'] }}">
                                                            {{ $site->site_status }}
                                                        </span>
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
                    return fetch(`/website/delete/${id}`, {
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
                        location.reload(); 
                    }, 1500);
                } else if (result.value && !result.value.success) {
                    toastr.error(result.value.message || "Failed to delete!");
                }
            });
        });
</script>
@endpush