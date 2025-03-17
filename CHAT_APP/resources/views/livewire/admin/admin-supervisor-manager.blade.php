@extends('layouts.app')

@section('sidebar')
    @livewire('admin.admin-sidebar')
@endsection

@section('dashboard')
    @livewire('admin.admin-dashboard')
@endsection

@section('chat-dashboard')
    <!-- Exclude dashboard for this page -->
@endsection

@section('content')
<body>
<div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
    <div class="card shadow bg-white border-white">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="text-success mb-0">Supervisors</h5>
        </div>
        <div class="card-body bg-white">
    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.supervisor.search') }}">
    <div class="row mb-3">
        <!-- Search by emp_id -->
        <div class="col-md-4">
            <input type="text" id = "employeeID" name="emp_id" class="form-control" placeholder="Employee ID"
                   value="{{ request('emp_id') }}">
        </div>
        
        <!-- Filter by Group Code -->
        <div class="col-md-4">
            <select name="group_code" class="form-select" id="group-filter">
                <option value="">Select Group</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->group_code }}" 
                        {{ request('group_code') == $group->group_code ? 'selected' : '' }}>
                        {{ $group->group_code }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="col-md-4">
            <button type="submit" class="btn btn-success w-100">Search</button>
            <button type="clear" class="btn btn-secondary w-100 mt-2" onclick="clearFilter()">Clear</button>
        </div>
    </div>
</form>
           
<!-- Table -->
<table id="table" class="table table-bordered" data-toggle="table" data-search="false" data-pagination="true" data-page-size="2" data-sortable="false">
    <thead class="table-success">
        <tr>
            <th>Name</th>
            <th>Employee ID</th>
            <th>Group Code</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($supervisors as $supervisor)
            <tr>
                <td>{{ $supervisor->user->name ?? 'N/A' }}</td>
                <td>{{ $supervisor->user->emp_id ?? 'N/A' }}</td>
                <td>{{ $supervisor->group->group_code ?? 'N/A' }}</td>
                <td>{{ $supervisor->user->email ?? 'N/A' }}</td>
                <td>
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateSupervisorModal" onclick="fetchSupervisorData({{ $supervisor->id }})">
                        <i class="fas fa-edit"></i>
                    </button>

                    <form id="deleteForm_{{ $supervisor->id }}" action="{{ route('admin.supervisor.delete', $supervisor->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-link text-danger" onclick="confirmDelete({{ $supervisor->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No supervisors found</td>
            </tr>
            @endforelse
    </tbody>
</table>

<!-- Pagination Links -->
@if($supervisors->isNotEmpty())
    <div class="d-flex justify-content-center">
        {{ $supervisors->links() }}
    </div>
@endif

</div>
</div>
</div>

   <!-- Supervisor Update Modal -->
<div class="modal fade" id="updateSupervisorModal" tabindex="-1" aria-labelledby="updateSupervisorLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateSupervisorForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSupervisorLabel">Update Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="updateEmpId" class="form-label">Employee ID</label>
                        <input type="text" id="updateEmpId" name="emp_id" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="updateName" class="form-label">Name</label>
                        <input type="text" id="updateName" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateEmail" class="form-label">Email</label>
                        <input type="email" id="updateEmail" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="updateGroupCode" class="form-label">Group</label>
                        <select id="updateGroupCode" class="form-select" name="group_code" required>
                            <option value="">Select</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->group_code }}">{{ $group->group_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

document.addEventListener('DOMContentLoaded', () => {
    const updateForm = document.getElementById('updateSupervisorForm');
    const saveButton = updateForm.querySelector('button[type="submit"]');
    const modalElement = document.getElementById('updateSupervisorModal');
    const cancelButton = modalElement.querySelector('.btn-secondary');
    const closeModalButton = modalElement.querySelector('.btn-close');

    let initialData = {};

    // Function to set initial form data
    function setInitialData() {
        initialData = {
            name: document.getElementById('updateName').value,
            email: document.getElementById('updateEmail').value,
            group: document.getElementById('updateGroupCode').value,
        };
    }

    // Function to check if there are changes in the form
    function hasUnsavedChanges() {
        const currentData = {
            name: document.getElementById('updateName').value,
            email: document.getElementById('updateEmail').value,
            group: document.getElementById('updateGroupCode').value,
        };
        return JSON.stringify(initialData) !== JSON.stringify(currentData);
    }

    // Function to handle unsaved changes confirmation
    function handleUnsavedChanges(event) {
        if (hasUnsavedChanges()) {
            const confirmDiscard = confirm('You have unsaved changes. Do you want to discard them?');
            if (!confirmDiscard) {
                event.preventDefault(); // Prevent modal close
                event.stopPropagation(); // Stop Bootstrap's closing behavior
            } else {
                setInitialData(); // Reset initial data to avoid repeated prompts
            }
        }
    }

    // Disable "Save Changes" button initially
    saveButton.disabled = true;

    // Enable "Save Changes" button only if there are changes
    function checkForChanges() {
        saveButton.disabled = !hasUnsavedChanges();
    }

    // Attach event listeners
    updateForm.addEventListener('input', checkForChanges);

    // Attach unsaved changes handler to modal close events
    modalElement.addEventListener('hide.bs.modal', handleUnsavedChanges);

    // Function to fetch supervisor data for editing
    window.fetchSupervisorData = function (supervisorId) {
        fetch(`/admin/supervisors/${supervisorId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Populate modal fields with supervisor data
                document.getElementById('updateEmpId').value = data.emp_id;
                document.getElementById('updateName').value = data.name;
                document.getElementById('updateEmail').value = data.email;
                document.getElementById('updateGroupCode').value = data.group_code;

                // Set the form's action attribute dynamically
                updateForm.action = `/admin/supervisors/${supervisorId}`;

                // Set the initial data
                setInitialData();
            })
            .catch(error => {
                console.error('Error fetching supervisor data:', error);
                alert('Failed to load supervisor data.');
            });
    };
});

    // Function to reset form values and redirect
    function clearFilter() {
        document.getElementById("employeeID").value = "";
        document.getElementById("group-filter").value = "";

        // Redirect to the desired route
        window.location.href = "{{ route('admin.supervisor') }}";
    }

    // Function to confirm delete action
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this supervisor?')) {
            document.getElementById('deleteForm_' + id).submit();
        }
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
@endsection