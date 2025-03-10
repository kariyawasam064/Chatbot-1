<!-- resources/views/header.blade.php -->
<header class="d-flex justify-content-between align-items-center p-3 bg-primary text-white">
    <!-- Left Corner: Logo -->
    <div class="logo">
        <img src="{{ asset('assets/Logo.png') }}" alt="SLT Logo" height="40">
    </div>
    <div class="d-flex align-items-center">
        <a href="#" class="group-code text-decoration-none me-3">
            GROUP: {{ session('supervisor_group', 'No Group Assigned') }}
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger me-3">Logout</button>
        </form>
        <a href="{{ route('supervisor.profile') }}" class="profile-icon">
            <i class="bi bi-person-circle" style="font-size: 24px;"></i>
        </a>
    </div>
</header>
