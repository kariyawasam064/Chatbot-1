@extends('layouts.app')

@section('sidebar')
    @livewire('admin.admin-sidebar')
@endsection

@section('dashboard')
    <!-- Exclude dashboard for this page -->
@endsection

@section('chat-dashboard')
    <!-- Exclude dashboard for this page -->
@endsection

@section('content')
<head>
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
</head>
<div class="container">
    <div class="col-md-10 main-content">
        <h4 class="text-center text-primary">My Profile</h4>
        <div class="row">
            <!-- Left Column -->
            <div class="profile">
                <div class="profile-picture text-center">
                    <i class="fa-solid fa-user-circle fa-4x"></i>
                    <h5 class="mt-2">{{ auth()->user()->name }}</h5> <!-- Display user's name -->
                    <button class="btn btn-dark mt-2">Change Profile Picture</button>
                </div>
                <div class="profile-details">
                    <p><strong>Role:</strong> {{ auth()->user()->role }}</p> <!-- Display user's role -->
                    <p><strong>Employee ID:</strong> {{ auth()->user()->emp_id }}</p> <!-- Display user's emp_id -->
                    <p><strong>Name:</strong>  {{ auth()->user()->name }}</p> <!-- Display user's name -->
                    <p><strong>Email:</strong>  {{ auth()->user()->email }}</p> <!-- Display user's email -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
