@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')

    @include("partials.mainhead")
    @include("partials.switcher")
    @include("partials.loader")
    @include("partials.header")
    @include("partials.sidebar")


    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <div class="page">


       <!-- Start::app-content -->
       <div class="main-content app-content">
           <div class="container-fluid">

               <!-- Page Header -->

               <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                 <div>
                     <h2 class="main-content-title fs-24 mb-1">All Users</h2>
                     <ol class="breadcrumb mb-0">
                         <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                         <li class="breadcrumb-item active" aria-current="page">User List</li>
                     </ol>
                 </div>
                 <div class="d-flex">

                 </div>
               </div>

               <!-- Start:: row-3 -->
               <div class="row">
                   <div class="col-xl-12">
                       <div class="card custom-card">
                           <div class="card-header">
                               <div class="card-title">
                                   User List
                               </div>
                           </div>
                           <div class="card-body">
                               <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap" style="width:100%">
                                   <thead>
                                       <tr>
                                           <th>Name</th>
                                           <th>Email</th>
                                           <th>Assigned Role</th>
                                           @if(auth()->user()->roles->contains('name', 'admin'))
                                                <th>Action</th>
                                           @endif
                                       </tr>
                                   </thead>
                                   <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            @if(auth()->user()->roles->contains('name', 'admin'))
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                               </table>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- End:: row-3 -->


           </div>
       </div>
       <!-- End::app-content -->




   </div>

    @include('partials.commonjs')
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
    @endpush

    @include('partials.custom_switcherjs')

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
