@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')
<style>
        .profile-cover__action {
            width: 100%;
            height: 100%;
            background: url('{{ asset($profile->cover_image) }}') no-repeat center center;
            background-size: cover;
        }
    </style>
    <div class="page">

        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->

                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">User Profile</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ old('name', $user->name ?? 'Unnamed User') }}</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden shadow-sm border-0 rounded-4">
                            <div class="card-body p-0">

                                <!-- Cover Photo -->
                                <div class="bg-gradient position-relative" style="height: 150px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                                    <div class="profile-cover__action"></div>
                                </div>

                                <!-- Profile Image (Overlapping) -->
                                <div class="text-center" style="margin-top: 77px;">
                                    <img src="{{ $profile->profile_image ? asset($profile->profile_image) : asset('uploads/profile/default-profile.png') }}"
                                        alt="Profile Image"
                                        class="rounded-circle border border-3 border-white shadow"
                                        width="100" height="100"
                                        style="object-fit: cover;">
                                </div>

                                <!-- Name & Designation -->
                                <div class="text-center mt-2">
                                    <h5 class="mb-0 fw-semibold text-dark">{{ $profile->username ?? $user->name }}</h5>
                                    <span class="text-muted small">{{ $profile->experience ?? 'Designation not set' }}</span>
                                </div>
                                <div class="text-center mt-1">
                                    <small class="text-muted d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-clock"></i>
                                        Last updated  {{ $profile->updated_at ? $profile->updated_at->diffForHumans() : $profile->updated_at->format('F d, Y') }}
                                    </small>
                                </div>


                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-center gap-3 mt-3">
                                    <button class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-medium">
                                        <i class="fa fa-plus me-1"></i> Follow
                                    </button>
                                    <button class="btn btn-outline-success btn-sm rounded-pill px-4 fw-medium">
                                        <i class="fa fa-comment me-1"></i> Message
                                    </button>
                                </div>

                                <!-- Stats -->
                                <div class="mt-4 border-top pt-3 text-center">
                                    <h6 class="text-primary fw-bold mb-0 fs-5">{{ $user->createdInvoices()->count() }}</h6>
                                    <small class="text-muted">Invoices Created</small>
                                </div>

                                <!-- Tabs -->
                                <div class="border-top pt-2">
                                    <ul class="nav nav-pills justify-content-center gap-2 py-2">
                                        <li class="nav-item">
                                            <a class="nav-link active rounded-pill px-3" data-bs-toggle="tab" href="#about">View Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link rounded-pill px-3" data-bs-toggle="tab" href="#edit">Edit Profile</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="row row-sm">
                    <div class="col-lg-12 col-md-12">
                    <div class="card custom-card main-content-body-profile">
                        <div class="tab-content">
                            <div class="main-content-body tab-pane p-4 active" id="about">
                                <div class="border rounded-4 shadow-sm bg-white">
                                <div class="p-4">
                                    <h5 class="text-uppercase text-primary fw-semibold mb-3">
                                        <i class="bi bi-person-fill me-2"></i> Profile Overview
                                    </h5>
                                    <p class="mb-3">{{ $profile->bio ?? 'Need to Update' }}</p>

                                    <h5 class="text-uppercase text-primary fw-semibold mb-3">
                                        <i class="bi bi-briefcase-fill me-2"></i> Designation
                                    </h5>
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-dark mb-1">{{ $profile->experience ?? 'Need to Update' }}</h6>
                                    </div>
                                </div>

                                    <hr class="my-0">

                                    <div class="p-4">
                                        <h6 class="text-uppercase text-primary fw-semibold mb-3">Contact</h6>
                                        <div class="row gy-3">
                                            <div class="col-md-4 d-flex align-items-start">
                                                <div class="bg-primary-subtle text-primary p-2 rounded me-3">
                                                    <i class="bi bi-telephone-forward fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Mobile</small>
                                                    <div>{{ $profile->mobile ?? 'Need to Update' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-start">
                                                <div class="bg-success-subtle text-success p-2 rounded me-3">
                                                    <i class="bi bi-lightning-charge fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Slack</small>
                                                    <div>{{ $profile->slack ?? 'Need to Update' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-start">
                                                <div class="bg-info-subtle text-info p-2 rounded me-3">
                                                    <i class="bi bi-geo-alt fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Current Address</small>
                                                    <div>{{ $profile->location ?? 'Need to Update' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-0">

                                    <div class="p-4">
                                        <h6 class="text-uppercase text-primary fw-semibold mb-3">Social Links</h6>
                                        <div class="row gy-3">
                                            <div class="col-md-3 d-flex align-items-start">
                                                <div class="bg-primary-subtle text-primary p-2 rounded me-3">
                                                    <i class="bi bi-github fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">GitHub</small><br>
                                                    <a href="{{ $profile->github ?? 'javascript:void(0);' }}" class="text-decoration-none">
                                                        {{ $profile->github ?? 'Need to Update' }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-start">
                                                <div class="bg-success-subtle text-success p-2 rounded me-3">
                                                    <i class="bi bi-twitter fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Twitter</small><br>
                                                    <a href="{{ $profile->twitter ?? 'javascript:void(0);' }}" class="text-decoration-none">
                                                        {{ $profile->twitter ?? 'Need to Update' }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-start">
                                                <div class="bg-info-subtle text-info p-2 rounded me-3">
                                                    <i class="bi bi-linkedin fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">LinkedIn</small><br>
                                                    <a href="{{ $profile->linkedin ?? 'javascript:void(0);' }}" class="text-decoration-none">
                                                        {{ $profile->linkedin ?? 'Need to Update' }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-start">
                                                <div class="bg-danger-subtle text-danger p-2 rounded me-3">
                                                    <i class="bi bi-link-45deg fs-5"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Portfolio</small><br>
                                                    <a href="{{ $profile->portfolio ?? 'javascript:void(0);' }}" class="text-decoration-none">
                                                        {{ $profile->portfolio ?? 'Need to Update' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="main-content-body tab-pane p-4 border-top-0" id="edit">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body">
                                        <h5 class="mb-4 text-primary fw-semibold">Update Profile Information</h5>

                                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label class="form-label">Profile Photo</label>
                                                    <input type="file" name="profile_image" class="form-control">
                                                    <div class="mt-2">
                                                        <img src="{{ $profile->profile_image }}" alt="Profile Image" class="rounded shadow-sm" width="100" height="100">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Cover Photo</label>
                                                    <input type="file" name="cover_image" class="form-control">
                                                    <div class="mt-2">
                                                        <img src="{{ $profile->cover_image }}" alt="Cover Image" class="rounded shadow-sm" width="150" height="80">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Your Good Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Bio</label>
                                                    <textarea name="bio" class="form-control" rows="3" placeholder="Write something...">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                                </div>
                                               
                                                <div class="col-md-6">
                                                    <label class="form-label">Experience</label>
                                                    <input type="text" name="experience" class="form-control" value="{{ old('experience', $profile->experience ?? '') }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" name="location" class="form-control" value="{{ old('location', $profile->location ?? '') }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Mobile</label>
                                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $profile->mobile ?? '') }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Slack</label>
                                                    <input type="text" name="slack" class="form-control" value="{{ old('slack', $profile->slack ?? '') }}">
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label">Portfolio</label>
                                                    <input type="text" name="portfolio" class="form-control" value="{{ old('portfolio', $profile->portfolio ?? '') }}">
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            <h5 class="mb-3 text-primary fw-semibold">Social Info</h5>

                                            <div class="row g-4">
                                                <div class="col-md-4">
                                                    <label class="form-label">GitHub</label>
                                                    <input type="text" name="github" class="form-control" value="{{ old('github', $profile->github ?? '') }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Twitter</label>
                                                    <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $profile->twitter ?? '') }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">LinkedIn</label>
                                                    <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin', $profile->linkedin ?? '') }}">
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                                                    <i class="bi bi-save me-1"></i> Update Profile
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>

            </div>
        </div>
        <!-- End::app-content -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="input-group">
                            <input type="search" class="form-control px-2 " placeholder="Search..."
                                aria-label="Username">
                            <a href="javascript:void(0);" class="input-group-text bg-primary text-white"
                                id="Search-Grid"><i class="fe fe-search header-link-icon fs-18"></i></a>
                        </span>
                        <div class="mt-3">
                            <div class="">
                                <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                                <div class="ps-2">
                                    <a href="javascript:void(0)" class="search-tags"><i
                                            class="fe fe-search me-2"></i>People<span></span></a>
                                    <a href="javascript:void(0)" class="search-tags"><i
                                            class="fe fe-search me-2"></i>Pages<span></span></a>
                                    <a href="javascript:void(0)" class="search-tags"><i
                                            class="fe fe-search me-2"></i>Articles<span></span></a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="fw-semibold text-muted mb-2 fs-13">Apps and pages</p>
                                <ul class="ps-2">
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="full-calendar.html"><span><i
                                                    class='bx bx-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Calendar</span></a>
                                    </li>
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="mail.html"><span><i
                                                    class='bx bx-envelope me-2 fs-14 bg-primary-transparent p-2 rounded-circle'></i>Mail</span></a>
                                    </li>
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="buttons.html"><span><i
                                                    class='bx bx-dice-1 me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Buttons</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                                <ul class="ps-2">
                                    <li class="p-1 align-items-center  mb-1 search-app">
                                        <a href="javascript:void(0)"
                                            class="text-primary"><u>http://spruko/html/spruko.com</u></a>
                                    </li>
                                    <li class="p-1 align-items-center mb-1 search-app">
                                        <a href="javascript:void(0)"
                                            class="text-primary"><u>http://spruko/demo/spruko.com</u></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block">
                        <div class="text-center">
                            <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all
                                results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection
@push('scripts')
@endpush
