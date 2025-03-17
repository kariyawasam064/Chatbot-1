@extends('layouts.reporter-app')

@section('sidebar')
    @livewire('reporter.reporter-sidebar')
@endsection

@section('dashboard')
    <!-- Exclude dashboard for this page -->
@endsection

@section('content')
<head>
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
</head>
    <div class="container">
        <div class="col-md-9 main-content">
            <h4 class="text-center text-primary">My Profile</h4>
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="profile-picture text-center">
                        <i class="fa-solid fa-user-circle fa-4x"></i>
                        <h5 class="mt-2">Dulan Perera</h5>
                        <button class="btn btn-dark mt-2">Change Profile Picture</button>
                    </div>
                    <div class="profile-details">
                        <p><strong>Role:</strong> Reporter</p>
                        <p><strong>Employee ID:</strong>  234567</p>
                        <p><strong>Name:</strong>  Dulan Perera</p>
                        <p><strong>Email:</strong>  dulan.perera@gmail.com</p>
                        <p><strong>Group Name:</strong> Colombo</p>
                        <p><strong>Group Code:</strong> G001</p>
                        <p><strong>Group Name:</strong> Kurunegala</p>
                        <p><strong>Group Code:</strong> G002</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="change-password">
                        <h5 class="text-success text-center">Change Password</h5>
                        <form>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" id="current_password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" id="new_password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm_password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="reset" class="btn btn-secondary me-2">Clear</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

