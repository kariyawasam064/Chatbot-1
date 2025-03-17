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
<div class="container mt-3">
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
            <h5 class="text-success mb-0">Groups</h5>
        </div>
            <div class="card-body bg-white">
            <div class="row mb-3">
        <div class="col-md-4 search-section">
            <select class="form-select" id="group-filter">
                <option selected value="">Select Group</option>
                @foreach($groups as $group)
                <option value="{{ $group->group_code }}">{{ $group->group_code }}</option>
                @endforeach
            </select>
        </div>
        <!-- Submit Button -->
        <div class="col-md-3">
            <button id="searchBtn" class="btn btn-success w-100">Search</button>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-secondary w-100" onclick="clearFilter()">Clear</button>
        </div>
    </div>

    <!-- Table -->
    <table
        id="table"
        class="table table-bordered"
        data-toggle="table"
        data-search="false"
        data-pagination="true"
        data-page-size="3"
        data-sortable="false"
    >
        <thead class="table-success">
            <tr>
                <th data-field="name" data-sortable="true">Group Name</th>
                <th data-field="emp_id" data-sortable="true">Group Code</th>
                <th data-field="group" data-sortable="true">Address</th>
                <th data-field="email" data-sortable="true">Contact Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="table-body">
            @foreach ($groups as $group)
            <tr>
                <td>{{ $group->group_name }}</td>
                <td>{{ $group->group_code }}</td>
                <td>{{ $group->address }}</td>
                <td>{{ $group->contact_number }}</td>
                <td>
                    <!-- Edit button -->
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateGroupModal" onclick="openUpdateModal({{ json_encode($group) }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    
                    <!-- Delete button -->
                    <form action="{{ route('group.destroy', $group->id) }}" method="POST" style="display:inline;" id="deleteForm{{ $group->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" title="Delete" class="btn btn-link text-danger" onclick="confirmDelete({{ $group->id }})">
                            <i class="fas fa-trash"></i>
                        </button> 
                    </form>       
                </td>
            </tr>   
            @endforeach
        </tbody>
    </table>
  </div>
</div>
</div>

    <!-- Update group Modal -->
    <div class="modal" id="updateGroupModal" tabindex="-1" aria-labelledby="updateGroupModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                    <h5 class="modal-title" id="addGroupModalLabel">Update Group</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateGroupForm" action="{{ route('group.update', ':id') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="updateGroupId" name="id">
                        <div class="mb-3">
                            <label for="updateGroupCode" class="form-label">Group Code</label>
                            <input type="text" id="updateGroupCode" class="form-control" name="group_code" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="updateName" class="form-label">Group Name</label>
                            <input type="text" id="updateName" class="form-control" name="group_name" required>
                        </div>
                        
                        <!-- Address Section with Textarea -->
                        <div class="mb-3">
                            <label for="updateAddress" class="form-label">Address</label>
                            <textarea id="updateAddress" class="form-control" rows="3" placeholder="Enter Address" name="address" required></textarea>
                        </div>
    
                        <div class="mb-3">
                            <label for="updateContactNumber" class="form-label">Contact Number</label>
                            <input type="text" id="updateContactNumber" class="form-control" name="contact_number" required>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    function clearFilter() {
    document.getElementById("group-filter").value = "";

    // Redirect to the desired route
    window.location.href = "{{ route('admin.group') }}";
    }


    document.getElementById('searchBtn').addEventListener('click', function () {
    const groupFilter = document.getElementById('group-filter').value;

    fetch('{{ route('group.search') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ group_code: groupFilter })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = ''; // Clear the table

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5">No groups found</td></tr>`;
            } else {
                // Populate the table with new rows
                data.forEach(group => {
                    const row = `
                        <tr id="group-${group.id}">
                            <td>${group.group_name || ''}</td>
                            <td>${group.group_code || ''}</td>
                            <td>${group.address || ''}</td>
                            <td>${group.contact_number || ''}</td>
                            <td>
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateGroupModal"
                                    onclick="openUpdateModals(${group.id},'${group.group_code || ''}', '${group.group_name || ''}', '${group.address || ''}', '${group.contact_number || ''}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('group.destroy', ['id' => $group->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger">
                                   <i class="fas fa-trash"></i>
                                </button>
                                </form>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }
        })
        .catch(error => console.error('Error:', error));
});

function confirmDelete(event) {
    // Display a confirmation dialog
    const isConfirmed = confirm('Are you sure you want to delete this group?');

    // Prevent the form submission if the user cancels
    if (!isConfirmed) {
        event.preventDefault();
        return false;
    }

    // Allow the form submission if the user confirms
    return true;
}

function openUpdateModals(id, groupCode, groupName,  address, contactNumber) {
    console.log("ID:", id);
    console.log("Group Code:", groupCode);
    console.log("Group Name:", groupName);
    console.log("Address:", address);
    console.log("Contact Number:", contactNumber);

    // Assign values to modal inputs
    document.getElementById('updateGroupCode').value = groupCode || '';
    document.getElementById('updateName').value = groupName || '';
    document.getElementById('updateAddress').value = address || '';
    document.getElementById('updateContactNumber').value = contactNumber || '';

    // Set the form action dynamically
    const formAction = '{{ route('group.update', ':id') }}'.replace(':id', id);
    document.getElementById('updateGroupForm').action = formAction;
}

    document.addEventListener('DOMContentLoaded', () => {
        const updateForm = document.getElementById('updateGroupForm');
        const saveButton = updateForm.querySelector('button[type="submit"]');
        const modalElement = document.getElementById('updateGroupModal');
        const cancelButton = modalElement.querySelector('.btn-secondary');
        const closeModalButton = modalElement.querySelector('.btn-close');

        let initialData = {};

        // Function to set initial form data
        function setInitialData() {
            initialData = {
                group_code: document.getElementById('updateGroupCode').value,
                group_name: document.getElementById('updateName').value,
                address: document.getElementById('updateAddress').value,
                contact_number: document.getElementById('updateContactNumber').value,
            };
        }

        // Function to check if there are unsaved changes
        function hasUnsavedChanges() {
            const currentData = {
                group_code: document.getElementById('updateGroupCode').value,
                group_name: document.getElementById('updateName').value,
                address: document.getElementById('updateAddress').value,
                contact_number: document.getElementById('updateContactNumber').value,
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

        // JavaScript to populate the modal with the selected group data
        window.openUpdateModal = function (group) {
            // Set the form action URL with the group ID
            const formAction = '{{ route('group.update', ':id') }}'.replace(':id', group.id);
            document.getElementById('updateGroupForm').action = formAction;

            // Set the form input values
            document.getElementById('updateGroupId').value = group.id;
            document.getElementById('updateGroupCode').value = group.group_code;
            document.getElementById('updateName').value = group.group_name;
            document.getElementById('updateAddress').value = group.address;
            document.getElementById('updateContactNumber').value = group.contact_number;

            // Set the initial data
            setInitialData();

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('updateGroupModal'));
            modal.show();
        };
    });
</script>


    <script>
        // JavaScript to show a confirmation dialog before deleting a group
        function confirmDelete(groupId) {
            const deleteForm = document.getElementById('deleteForm' + groupId);

            // Display a confirmation dialog
            if (confirm("Are you sure you want to delete this group?")) {
                deleteForm.submit(); // Submit the form if confirmed
            }
        }
    </script>
@endsection