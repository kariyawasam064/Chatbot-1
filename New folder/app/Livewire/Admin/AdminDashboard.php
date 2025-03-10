<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Skill;
use App\Models\Supervisor;
use App\Models\Group;
use App\Models\User;

class AdminDashboard extends Component
{
    public $skills;
    public $groups;
    public $agentCount;
    public $supervisorCount;
    public $reporterCount;
    public $groupCount;
    public $emp_id, $name, $email, $password, $confirmPassword, $group;

    public function mount()
    {
        // Fetch skills and groups data
        $this->skills = Skill::all();
        $this->groups = Group::all();
        $this->loadGroup();

        // Fetch the agent count
        $this->agentCount = User::where('role', 'agent')
            ->count();

        // Fetch the supervisor count
        $this->supervisorCount = User::where('role', 'supervisor')
            ->count();

        // Fetch the group count
        $this->groupCount = Group::count();

        // Fetch the reporter count
        $this->reporterCount = User::where('role', 'reporter')
            ->count();

        // Handle the redirection if no groups are available
        if ($this->groups->isEmpty()) {
            session()->flash('error', 'No groups available.');
            redirect()->route('admin.group');
        }
    }

    public function loadGroup()
    {
        $this->groups = Group::all(); // Load groups from the database
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}

