<body>
    <div class="container py-3">  
        <div class="row gy-1 justify-content-center">
              <!-- Supervisor Section -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-comments fa-2x me-2"></i>
                        <h4 class="card-title mb-0">Supervisor</h4>
                    </div>
                    <div class="circle mx-auto mb-3">{{ $supervisorCount }}</div>
                    <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addSupervisorModal" onclick="openAddForm('Supervisor')">
                        <i class="fa fa-plus-circle me-2"></i> Add
                    </button>
                </div>
            </div>
        </div>
            
        <!-- Agent Section -->
        <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-comments fa-2x me-2"></i>
                        <h4 class="card-title mb-0">Agent</h4>
                    </div>
                    <div class="circle mx-auto mb-3">{{ $agentCount }}</div>
                    <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addAgentModal" onclick="openAddForm('Agent')">
                        <i class="fa fa-plus-circle me-2"></i> Add
                    </button>
                </div>
            </div>
        </div>


            <!-- Reporter Section -->
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <div class="card-body d-flex align-items-center">
                        <i class="fa fa-comments fa-2x me-2"></i>
                            <h4 class="card-title mb-0">Reporter</h4>
                        </div>
                        <div class="circle mx-auto mb-3">{{ $reporterCount }}</div>
                        <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addReporterModal" onclick="openAddForm('Reporter')">
                            <i class="fa fa-plus-circle me-2"></i> Add
                        </button>
                    </div>
                </div>
            </div>

            <!-- Group Section -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-comments fa-2x me-2"></i>
                                <h4 class="card-title mb-0">Group</h4>
                            </div>
                            <div class="circle mx-auto mb-3">{{ $groupCount }}</div>
                            <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addGroupModal" onclick="openAddForm('Group')">
                                <i class="fa fa-plus-circle me-2"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        
   <!-- Add Agent Modal -->
<div class="modal" id="addAgentModal" tabindex="-1" aria-labelledby="addAgentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                <h5 class="modal-title" id="addAgentModalLabel">Add Agent</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAgentForm" action="{{ route('agents.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="employeeId" class="form-label">Employee ID</label>
                        <input type="text" id="employeeId" class="form-control" name="employeeId">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email">
                    </div>

                    <!-- Group Section -->
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select id="group" class="form-select" name="group">
                            @if($groups->isEmpty())
                                <option value="">No groups available</option>
                            @else
                                <option value="">Select</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->group_code }}">{{ $group->group_code }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Skills Section -->
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
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="add_skill_{{ $skill->id }}">
                                        <label class="form-check-label" for="add_skill_{{ $skill->id }}">
                                            {{ $skill->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="passwordAgent" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="passwordAgent" class="form-control" name="password" placeholder="Enter your password" aria-describedby="togglePasswordAgent">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordAgent" onclick="togglePasswordVisibility('passwordAgent', 'passwordIconAgent')">
                                <i class="fa fa-eye" id="passwordIconAgent"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPasswordAgent" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="confirmPasswordAgent" class="form-control" name="password_confirmation" placeholder="Confirm your password" aria-describedby="toggleConfirmPasswordAgent">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPasswordAgent" onclick="togglePasswordVisibility('confirmPasswordAgent', 'confirmPasswordIconAgent')">
                                <i class="fa fa-eye" id="confirmPasswordIconAgent"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetForm('addAgentModal')">Clear</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Add Supervisor Modal -->
        <div class="modal" id="addSupervisorModal" tabindex="-1" aria-labelledby="addSupervisorModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                        <h5 class="modal-title" id="addSupervisorModalLabel">Add Supervior</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

            <div class="modal-body">
                <!-- Change wire:submit.prevent to a regular form submission -->
                <form method="POST" action="{{ route('admin.supervisor.add') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="emp_id" class="form-label">Employee ID</label>
                        <input type="text" id="emp_id" class="form-control" name="emp_id">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <select id="group" name="group" class="form-select" required>
                            <option value="">Select</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->group_code }}" {{ old('group') == $group->group_code ? 'selected' : '' }}>
                                    {{ $group->group_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="passwordSupervisor" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="passwordSupervisor" class="form-control" name="password" placeholder="Enter your password" aria-describedby="togglePasswordSupervisor">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordSupervisor" onclick="togglePasswordVisibility('passwordSupervisor', 'passwordIconSupervisor')">
                                <i class="fa fa-eye" id="passwordIconSupervisor"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPasswordSupervisor" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="confirmPasswordSupervisor" class="form-control" name="password_confirmation" placeholder="Confirm your password" aria-describedby="toggleConfirmPasswordSupervisor">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPasswordSupervisor" onclick="togglePasswordVisibility('confirmPasswordSupervisor', 'confirmPasswordIconSupervisor')">
                                <i class="fa fa-eye" id="confirmPasswordIconSupervisor"></i>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetForm('addSupervisorModal')">Clear</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Reporter Modal -->
<div class="modal" id="addReporterModal" tabindex="-1" aria-labelledby="addReporterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                <h5 class="modal-title" id="addReporterModalLabel">Add Reporter</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Change wire:submit.prevent to a regular form submission -->
                <form method="POST" action="{{ route('reporters.store') }}">
                    @csrf <!-- Add CSRF token for security -->
                    
                    <div class="mb-3">
                        <label for="emp_id" class="form-label">Employee ID</label>
                        <input type="text" id="emp_id" class="form-control" name="emp_id">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" name="email">
                    </div>

                    <div class="mb-3"> 
                        <label for="group_code" class="form-label">Group</label>
                        <div class="form-check">
                            @foreach($groups as $group)
                            <input class="form-check-input" type="checkbox" name="group_code[]" value="{{ $group->group_code }}" id="group_{{ $group->group_code }}"
                            @if(isset($groupCodes) && in_array($group->group_code, $groupCodes)) checked @endif>
                            <label class="form-check-label" for="group_{{ $group->group_code }}">
                                {{ $group->group_code }}
                            </label>
                            <br>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="passwordReporter" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="passwordReporter" class="form-control" name="password" placeholder="Enter your password" aria-describedby="togglePasswordReporter">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordReporter" onclick="togglePasswordVisibility('passwordReporter', 'passwordIconReporter')">
                                <i class="fa fa-eye" id="passwordIconReporter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPasswordReporter" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="confirmPasswordReporter" class="form-control" name="password_confirmation" placeholder="Confirm your password" aria-describedby="toggleConfirmPasswordReporter">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPasswordReporter" onclick="togglePasswordVisibility('confirmPasswordReporter', 'confirmPasswordIconReporter')">
                                <i class="fa fa-eye" id="confirmPasswordIconReporter"></i>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetForm('addReporterModal')">Clear</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
       <!-- Add Group Modal -->
       <div class="modal" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white; color: rgb(4, 167, 4);">
                        <h5 class="modal-title" id="addGroupModalLabel">Add Group</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('group.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="groupCode" class="form-label">Group Code</label>
                                <input type="text" id="groupCode" class="form-control" name="group_code" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Group Name</label>
                                <input type="text" id="name" class="form-control" name="group_name" required>
                            </div>
                            
                            <!-- Address Section with Textarea -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" class="form-control" rows="3" placeholder="Enter Address" name="address" required></textarea>
                            </div>
        
                            <div class="mb-3">
                                <label for="cnumber" class="form-label">Contact Number</label>
                                <input type="text" id="cnumber" class="form-control" name="contact_number" required>
                            </div>
        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="resetForm('addGroupModal')">Clear</button>
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

function openAddForm(type) {
    // Identify the modal and form based on the type
    const modalId = `add${type}Modal`;
    const formId = `add${type}Form`;

    // Get the form and modal elements
    const form = document.getElementById(formId);
    const modalElement = document.getElementById(modalId);

    if (form) {
        // Reset the form fields
        form.reset();

        // Uncheck all checkboxes (if any exist)
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    if (modalElement) {
        // Show the modal using Bootstrap's Modal API
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
}

function resetForm(modalId) {
    const modal = document.getElementById(modalId);

    // Reset text input fields
    const textInputs = modal.querySelectorAll("input[type='text'], input[type='email'], input[type='password']");
    textInputs.forEach(input => {
        input.value = "";
    });

    // Reset dropdowns
    const dropdowns = modal.querySelectorAll("select");
    dropdowns.forEach(dropdown => {
        dropdown.selectedIndex = 0;
    });

    // Uncheck all checkboxes
    const checkboxes = modal.querySelectorAll("input[type='checkbox']");
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Clear textarea fields
    const textareas = modal.querySelectorAll("textarea");
    textareas.forEach(textarea => {
        textarea.value = ""; // Clear the content of the textarea
    });

    // Reset error messages if applicable
    const errorMessage = modal.querySelector("#error-message");
    if (errorMessage) {
        errorMessage.style.display = 'none';
        errorMessage.textContent = '';
    }
}


        function togglePasswordVisibility(passwordFieldId, passwordIconId) {
        const passwordField = document.getElementById(passwordFieldId);
        const passwordIcon = document.getElementById(passwordIconId);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

        </script>

</body>
</html>


