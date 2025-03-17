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
        <div class="card-header bg-white">
            <h5 class="text-success mb-0">Agents</h5>
        </div>
        <div class="card-body bg-white">
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
                    data-sortable="false"
            >
                <thead class="table-success">
                    <tr>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="emp_id" data-sortable="true">Employee ID</th>
                        <th data-field="group" data-sortable="true">Group</th>
                        <th data-field="email" data-sortable="true">Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                    <tr>
                        <td>{{ $agent->name }}</td>
                        <td>{{ $agent->emp_id }}</td>
                        <td>{{ $agent->group }}</td>
                        <td>{{ $agent->email }}</td>
                        <td>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateAgentModal" onclick="editAgent('{{ $agent->emp_id }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('agents.destroy', $agent->emp_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No agents found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

   <!-- Update Agent Modal -->
    <div class="modal" id="updateAgentModal" tabindex="-1" aria-labelledby="updateAgentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                    <h5 class="modal-title" id="updateSkillModalLabel">Update Agent</h5>
                    <button type="button" class="btn-close text-white" id="close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="updateAgentForm" method="POST">
                        @csrf
                        <input type="hidden" id="updateEmpId" name="emp_id" />
                        <div class="mb-3">
                            <label for="updateName" class="form-label">Name</label>
                            <input type="text" id="updateName" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="updateEmail" name="email" required />
                        </div>
                        <div class="mb-3">
                            <label for="group" class="form-label">Group</label>
                            <select id="updateGroup" class="form-select" name="group" required>
                                <option value="">Select</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->group_code }}">{{ $group->group_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            @php
                                // Get unique languages dynamically from the skills collection
                                $languages = $skills->pluck('language')->unique();
                                // Group skills by language
                                $skillsGroupedByLanguage = $skills->groupBy('language');
                            @endphp

                            @foreach($languages as $language)
                                <div class="mb-2">
                                    <strong>{{ $language }}</strong>
                                </div>
                                @if(isset($skillsGroupedByLanguage[$language]))
                                    @foreach($skillsGroupedByLanguage[$language] as $skill)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="update_skill_{{ $skill->id }}">
                                            <label class="form-check-label" for="update_skill_{{ $skill->id }}">
                                                {{ $skill->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted ms-3">No skills available</p>
                                @endif
                            @endforeach
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

    // Function to reset form values and redirect
    function clearFilter() {
        document.getElementById("empID").value = "";
        document.getElementById("group-filter").value = "";

        // Redirect to the desired route
        window.location.href = "{{ route('admin.agent') }}";
    }

    // Fetch filtered agents
    document.getElementById('searchBtn').addEventListener('click', function () {
        const empID = document.getElementById("empID").value;
        const group = document.getElementById("group-filter").value;

        // Fetch filtered data via AJAX
        fetch(`{{ route('agents.filter') }}?empID=${empID}&group=${group}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#table tbody');
                if (data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>`;
                } else {
                    tableBody.innerHTML = data.map(agent => `
                        <tr>
                            <td>${agent.name}</td>
                            <td>${agent.emp_id}</td>
                            <td>${agent.group}</td>
                            <td>${agent.email}</td>
                            <td>
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateAgentModal" onclick="editAgent('${agent.emp_id}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('agents.destroy', '') }}/${agent.emp_id}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this agent?');">
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

// Disable "Save Changes" button if no changes
const updateForm = document.getElementById('updateAgentForm');
const saveButton = updateForm.querySelector('button[type="submit"]');
const skillsCheckboxes = document.querySelectorAll('input[name="skills[]"]');
const cancelButton = document.querySelector('#close-btn'); // Close button in the modal
const modalElement = document.getElementById('updateAgentModal');

let initialData = {};

function setInitialData() {
    initialData = {
        name: document.getElementById('updateName').dataset.initialValue,
        email: document.getElementById('updateEmail').dataset.initialValue,
        group: document.getElementById('updateGroup').dataset.initialValue,
        skills: Array.from(skillsCheckboxes)
            .filter(input => input.checked)
            .map(input => input.value),
    };
}

function checkForChanges() {
    const currentData = {
        name: document.getElementById('updateName').value,
        email: document.getElementById('updateEmail').value,
        group: document.getElementById('updateGroup').value,
        skills: Array.from(skillsCheckboxes)
            .filter(input => input.checked)
            .map(input => input.value),
    };

    const hasChanges = JSON.stringify(initialData) !== JSON.stringify(currentData);
    saveButton.disabled = !hasChanges;
    return hasChanges; // Return whether there are unsaved changes
}

// Add event listeners
updateForm.addEventListener('input', checkForChanges);
skillsCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', checkForChanges);
});

// Show confirmation dialog on close or cancel
function confirmDiscardChanges(event) {
    if (checkForChanges()) {
        const confirmDiscard = confirm('You have unsaved changes. Do you want to discard them?');
        if (!confirmDiscard) {
            event.preventDefault(); // Prevent modal from closing
        }
    }
}

// Attach confirmation to modal close and cancel buttons
modalElement.addEventListener('hide.bs.modal', confirmDiscardChanges);
cancelButton.addEventListener('click', confirmDiscardChanges);

// Populate modal with agent data and set initial values
function editAgent(empId) {
    fetch(`/agents/edit/${empId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const { agent, group, skills } = data;

            document.getElementById('updateEmpId').value = agent.emp_id;

            const nameField = document.getElementById('updateName');
            const emailField = document.getElementById('updateEmail');
            const groupField = document.getElementById('updateGroup');

            nameField.value = agent.name;
            nameField.dataset.initialValue = agent.name;

            emailField.value = agent.email;
            emailField.dataset.initialValue = agent.email;

            groupField.value = group || '';
            groupField.dataset.initialValue = group || '';

            skillsCheckboxes.forEach(input => {
                input.checked = skills.map(skill => parseInt(skill)).includes(parseInt(input.value));
            });

            saveButton.disabled = true;
            updateForm.action = `/agents/update/${agent.emp_id}`;
            setInitialData(); // Set initial data after populating the form
        })
        .catch(error => {
            console.error('Error fetching agent details:', error);
            alert('Error fetching agent details. Please try again.');
        });
}

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
@endsection