<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header-footer.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div>
@include('livewire.admin.admin-header')
<div class="app">
    <div class="main">
        <div class="d-flex">
            <!-- Sidebar -->
            @livewire('admin.admin-sidebar')

            <!-- Main Content -->
            <div class="flex-grow-1 p-4">
                @hasSection('dashboard')
                    @yield('dashboard')
                @else
                    @livewire('admin.admin-dashboard')
                @endif
                
                @hasSection('chat-dashboard')
                    @yield('chat-dashboard')
                @else
                    @livewire('admin.admin-chat-view-dashboard')
                @endif
            </div>
            
            <div class="flex-grow-1 p-4">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('livewire.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js">
        // Get all nav links
const navLinks = document.querySelectorAll('#sidebar .nav-link');

// Add click event to each link
navLinks.forEach(link => {
    link.addEventListener('click', function () {
        // Remove 'active' class from all links
        navLinks.forEach(nav => nav.classList.remove('active'));
        
        // Add 'active' class to the clicked link
        this.classList.add('active');
    });
});

    </script>

    <div>
        
    @livewireScripts
</body>
</html>
