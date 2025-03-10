<!-- Sidebar Container -->
<div id="sidebar" class="d-flex flex-column bg-primary text-white vh-100" style="width: 250px;">

    <!-- Navigation Links -->
    <nav class="nav flex-column">
        <a href="{{ route('supervisor.dashboard') }}" class="nav-link text-white py-2"><i class="bi bi-house"></i> Dashboard</a>
        <a href="{{ route('supervisor.chat.history') }}" class="nav-link chat-history"><i class="bi bi-chat-dots"></i> Chats</a>
        <a href="{{ route('supervisor.agent') }}" class="nav-link text-white py-2"><i class="bi bi-people"></i> Agents</a>
    </nav>

    
</div>
