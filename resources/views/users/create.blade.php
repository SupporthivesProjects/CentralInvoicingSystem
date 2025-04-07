@extends('layouts.app')

@section('content')
{{--
<div class="container">
    <h2>Add New User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Roles</label>
            <select name="roles[]" class="form-control" multiple required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Add User</button>
    </form>



</div>
--}}

<div class="card-header justify-content-between">
    <div class="card-title">
        Vertical Forms
    </div>
    <div class="prism-toggle">
        <button class="btn btn-sm btn-primary-light">Show Code<i class="ri-eye-line ms-2 d-inline-block align-middle fs-14"></i></button>
    </div>
</div>
<div class="card-body">
    <div class="mb-3">
        <label for="form-text" class="form-label fs-14 text-dark">Enter name</label>
        <input type="text" class="form-control" id="form-text" placeholder="">
    </div>
    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">Enter
            Password</label>
        <input type="password" class="form-control" id="form-password" placeholder="">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="" id="invalidCheck"
            required="">
        <label class="form-check-label" for="invalidCheck">
            Accept Policy
        </label>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</div>

@endsection
