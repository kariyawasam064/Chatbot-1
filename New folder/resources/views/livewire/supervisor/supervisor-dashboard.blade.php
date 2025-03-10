<body>
<div class="container py-3">
        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container py-3">
        <div class="row gy-1">
            <!-- Agent Section -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-user fa-2x me-2"></i>
                            <h4 class="card-title mb-0">Agent</h4>
                        </div>
                        <div class="circle mx-auto mb-3">{{ $agentCount }}</div>
                        <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addAgentModal" onclick="openAddAgentForm()">
                        <i class="fa fa-plus-circle me-2"></i> Add
                        </button>
                    </div>
                </div>
            </div>

              <!-- Active Chats -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-comments fa-2x me-2"></i>
                            <h4 class="card-title mb-0">Active Chats</h4>
                        </div>
                        <div class="circle mx-auto mb-3" style="background-color: #28a745; color: white;">25</div>
                        <button class="btn btn-success w-100">View</button>
                    </div>
                </div>
            </div>

            <!-- Resolved Chats -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-check-circle fa-2x me-2"></i>
                            <h4 class="card-title mb-0">Resolved Chats</h4>
                        </div>
                        <div class="circle mx-auto mb-3" style="background-color: #007bff; color: white;">50</div>
                        <button class="btn btn-secandary w-100">View</button>
                    </div>
                </div>
            </div>

            <!-- Pending Chats -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-clock fa-2x me-2"></i>
                            <h4 class="card-title mb-0">Pending Chats</h4>
                        </div>
                        <div class="circle mx-auto mb-3" style="background-color: #ffc107; color: white;">15</div>
                        <button class="btn btn-warning w-100">View</button>
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
                <form id="addAgentForm" action="{{ route('supervisor.agents.store') }}" method="POST">
                    @csrf
                    <!-- Error Message -->
                    <div id="error-message" class="text-danger" style="display: none;"></div>

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
                        <input type="text" id="group" class="form-control" name="group" value="{{ session('supervisor_group') }}" readonly>
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

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" aria-describedby="togglePassword">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="confirmPassword" class="form-control" name="password_confirmation" placeholder="Confirm your password" aria-describedby="toggleConfirmPassword">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" onclick="toggleConfirmPasswordVisibility()">
                                <i class="fa fa-eye" id="confirmPasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Clear</button>
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

function openAddAgentForm() {
    const addAgentForm = document.getElementById('addAgentForm');

    // Reset the form fields
    addAgentForm.reset();

    // Uncheck all skill checkboxes
    const addSkillCheckboxes = addAgentForm.querySelectorAll('input[type="checkbox"]');
    addSkillCheckboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Show the Add Agent Modal
    const addAgentModal = new bootstrap.Modal(document.getElementById('addAgentModal'));
    addAgentModal.show();
}


function resetForm() {
    // Reset text input fields
    document.getElementById("employeeId").value = "";
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("password").value = "";
    document.getElementById("confirmPassword").value = "";

    // Reset the group dropdown to the default option
    document.getElementById("group").selectedIndex = 0;

    // Uncheck all skills checkboxes
    const skillCheckboxes = document.querySelectorAll("input[name='skills[]']");
    skillCheckboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Reset error message display
    document.getElementById("error-message").style.display = 'none';
    document.getElementById("error-message").textContent = '';
}

        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
        
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
        
        function toggleConfirmPasswordVisibility() {
            const confirmPasswordField = document.getElementById('confirmPassword');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');
        
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                confirmPasswordIcon.classList.remove('fa-eye');
                confirmPasswordIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordField.type = 'password';
                confirmPasswordIcon.classList.remove('fa-eye-slash');
                confirmPasswordIcon.classList.add('fa-eye');
            }
        }
        
        </script>
          
</body>
</html>


