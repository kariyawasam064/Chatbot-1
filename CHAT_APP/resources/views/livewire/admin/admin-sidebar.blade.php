<!-- Sidebar Container -->
<div id="sidebar" class="d-flex flex-column bg-primary text-white vh-100" style="width: 250px;">

    <!-- Navigation Links -->
    <nav class="nav flex-column">
        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white py-2"><i class="bi bi-house"></i> Dashboard</a>
        <a href="{{ route('admin.chat-history') }}" class="nav-link chat-history"><i class="bi bi-chat-dots"></i> Chats</a>
        <a href="{{ route('admin.supervisor') }}" class="nav-link text-white py-2"><i class="bi bi-person"></i> Supervisors</a>
        <a href="{{ route('admin.agent') }}" class="nav-link text-white py-2"><i class="bi bi-people"></i> Agents</a>
        <a href="{{ route('admin.reporter') }}" class="nav-link text-white py-2"><i class="bi bi-clipboard"></i> Reporters</a>
        <a href="{{ route('admin.group') }}" class="nav-link text-white py-2"><i class="bi bi-geo-alt"></i> Groups</a>
        <a href="{{ route('admin.skill') }}" class="nav-link text-white py-2"><i class="bi bi-gear"></i> Skills</a>
    </nav>

    
</div>
