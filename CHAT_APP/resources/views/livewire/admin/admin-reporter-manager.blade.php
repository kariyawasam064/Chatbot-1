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
            <h5 class="text-success mb-0">Reporters</h5>
        </div>
        <div class="card-body bg-white">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-md-4 search-section">
                    <input type="text" id="empID" class="form-control" placeholder="Employee ID">
                </div>
                <div class="col-md-4 search-section">
                    <select class="form-select" id="group-filter">
                        <option selected value="">Select Group</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->group_code }}">{{ $group->group_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button id="searchBtn" class="btn btn-success w-100">Search</button>
                    <button type="button" class="btn btn-secondary w-100 mt-2" onclick="clearFilter()">Clear</button>
                </div>
            </div>

            <table
    id="table"
    class="table table-bordered"
    data-toggle="table"
    data-search="false"
    data-pagination="true"
    data-page-size="2"
    data-sortable="true"
>
    <thead class="table-success">
        <tr>
            <th>Name</th>
            <th>Employee ID</th>
            <th>Group</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($reporters as $reporter)
    <tr>
        <td>{{ $reporter->name }}</td>
        <td>{{ $reporter->emp_id }}</td>
        <td>{{ $reporter->group }}</td> <!-- Display comma-separated group codes -->
        <td>{{ $reporter->email }}</td>
        <td>
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateReporterModal" onclick="editReporter('{{ $reporter->emp_id }}')">
                <i class="fas fa-edit"></i>
            </button>
            <form action="{{ route('reporters.destroy', $reporter->emp_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this reporter?');">
                @csrf
                <button type="submit" class="btn btn-link text-danger">
                    <i class="fas fa-trash text-danger"></i>
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">No Reporters Found</td>
    </tr>
@endforelse

    </tbody>
</table>
        </div>
    </div>
</div>

<!-- Update Reporter Modal -->
<div class="modal" id="updateReporterModal" tabindex="-1" aria-labelledby="updateReporterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                <h5 class="modal-title" id="updateReporterModalLabel">Update Reporter</h5>
                <button type="button" class="btn-close text-white" id="close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateReporterForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div id="loading" style="display:none;">Loading...</div>
                        <input type="hidden" id="updateEmpId" name="emp_id" />
                        <div class="mb-3">
                            <label for="updateName" class="form-label">Name</label>
                            <input type="text" id="updateName" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEmail" class="form-label">Email</label>
                            <input type="email" id="updateEmail" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateGroup" class="form-label">Groups</label>
                            <div id="groupsContainer">
                                @foreach($groups as $group)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="groups[]" value="{{ $group->group_code }}" id="group_{{ $group->group_code }}">
                                        <label class="form-check-label" for="group_{{ $group->group_code }}">
                                            {{ $group->group_code }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary save-btn" disabled>Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('updateReporterForm');
    const saveButton = document.querySelector('.save-btn');
    const cancelButton = document.querySelector('.cancel-btn');
    const closeButton = document.getElementById('close-btn');
    let initialFormState = null; // To store the initial state of the form

    // Function to get the current state of the form
    const getFormState = () => {
        const formData = new FormData(form);
        const state = {};
        formData.forEach((value, key) => {
            if (!state[key]) state[key] = [];
            state[key].push(value);
        });
        return JSON.stringify(state);
    };

    // Store the initial state when the form is populated
    const setInitialFormState = () => {
        initialFormState = getFormState();
        saveButton.disabled = true; // Disable Save button initially
    };

    // Function to check if the form state has changed
    const isFormStateChanged = () => {
        return initialFormState !== getFormState();
    };

    // Add event listeners to input elements to detect changes
    form.querySelectorAll('input, select, textarea').forEach((input) => {
        input.addEventListener('input', () => {
            saveButton.disabled = !isFormStateChanged(); // Enable Save button only if changes are detected
        });
    });

    // Add event listener for checkboxes to detect changes
    form.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            saveButton.disabled = !isFormStateChanged(); // Enable Save button only if changes are detected
        });
    });

    // Confirm discard changes on Cancel or Close button click
    const confirmDiscard = (event) => {
        if (isFormStateChanged()) {
            const confirmation = confirm('You have unsaved changes. Are you sure you want to discard them?');
            if (!confirmation) {
                event.preventDefault();
            } else {
                setInitialFormState(); // Reset the form state after discarding
            }
        }
    };

    cancelButton.addEventListener('click', confirmDiscard);
    closeButton.addEventListener('click', confirmDiscard);

    // When the modal is opened, populate it with data and set the initial state
    window.editReporter = function (empId) {
        document.getElementById('loading').style.display = 'block'; // Show loading indicator
        fetch(`/reporters/edit/${empId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const { reporter, groups } = data;

                document.getElementById('updateEmpId').value = reporter.emp_id;
                const nameField = document.getElementById('updateName');
                const emailField = document.getElementById('updateEmail');

                nameField.value = reporter.name;
                emailField.value = reporter.email;

                // Loop through each checkbox and check it based on the group codes
                const groupCheckboxes = document.querySelectorAll('input[name="groups[]"]');
                groupCheckboxes.forEach(input => {
                    input.checked = groups.includes(input.value);
                });

                // Set the correct form action URL
                form.action = `/reporters/update/${empId}`;

                document.getElementById('loading').style.display = 'none'; // Hide loading indicator
                setInitialFormState(); // Store the initial state after populating the form
            })
            .catch(error => {
                console.error('Error fetching reporter details:', error);
                document.getElementById('loading').style.display = 'none'; // Hide loading if there's an error
            });
    };
});



// Function to reset form values and redirect
function clearFilter() {
        document.getElementById("empID").value = "";
        document.getElementById("group-filter").value = "";

        // Redirect to the desired route
        window.location.href = "{{ route('admin.reporter') }}";
    }

    // Function to confirm delete action
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this reporter?')) {
            document.getElementById('deleteForm_' + id).submit();
        }
    }

document.getElementById('searchBtn').addEventListener('click', function () {
    const empID = document.getElementById("empID").value;
    const group = document.getElementById("group-filter").value;

    // Fetch filtered data via AJAX
    fetch(`{{ route('reporters.filter') }}?empID=${empID}&group=${group}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#table tbody');
            if (data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">No records found</td>
                    </tr>`;
            } else {
                tableBody.innerHTML = data.map(reporter => `
                    <tr>
                        <td>${reporter.name}</td>
                        <td>${reporter.emp_id}</td>
                        <td>${reporter.group}</td>
                        <td>${reporter.email}</td>
                        <td>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateReporterModal" onclick="fetchReporterData('${reporter.emp_id}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('reporters.destroy', '') }}/${reporter.emp_id}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this reporter?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                `).join('');
            }
        });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
