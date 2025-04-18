@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')

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
                                <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th class="text-center">Assigned Role</th>
                                            <th>Status</th>
                                            @if (auth()->user()->roles->contains('name', 'admin'))
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>

                                                <!-- Assigned Role Centered -->
                                                <td class="text-center">
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>

                                                <td class="text-center">
                                                    @if ($user->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                @if (auth()->user()->roles->contains('name', 'admin'))
                                                    <!-- Action Buttons Centered -->
                                                    <td class="text-center">
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-warning mb-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" class="d-inline mb-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('users.toggleStatus', $user->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button
                                                                class="btn btn-sm {{ $user->status ? 'btn-secondary' : 'btn-success' }}">
                                                                <i
                                                                    class="fas {{ $user->status ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                                {{ $user->status ? 'Make Inactive' : 'Make Active' }}
                                                            </button>
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
@endsection

@push('scripts')
@endpush
