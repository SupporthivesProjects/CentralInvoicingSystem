@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@push('styles')
<link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
<link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endpush

@section('content')
    @include("partials/mainhead")
    @include("partials/switcher")
    @include("partials/loader")
    @include("partials/header")
    @include("partials/sidebar")



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
                            <div class="card-header">
                                <div class="card-title">Connected Websites</div>
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
    

    @include("partials/commonjs")

@push('scripts')
<script src="{{ asset('libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
  <!-- Datatables Cdn -->
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <!-- Internal Datatables JS -->
    <script src="{{ asset('js/datatables.js') }}"></script>
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

@include("partials/custom_switcherjs")


@endsection