<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\Skill;
use App\Models\Group;
use App\Models\User;

class SupervisorDashboard extends Component
{
    public $skills;
    public $groups;
    public $agentCount;
    public $supervisorGroup; // Add this property

    public function mount()
    {
        // Fetch skills and groups data
        $this->skills = Skill::all();
        $this->groups = Group::all();

        // Access the supervisor group from the session
        $this->supervisorGroup = session('supervisor_group');

        // Fetch the agent count for the supervisor's group
        if ($this->supervisorGroup) {
            $this->agentCount = User::where('role', 'agent')
                ->join('agent', 'users.emp_id', '=', 'agent.emp_id') // Assuming agent table is named 'agents'
                ->where('agent.group_code', $this->supervisorGroup) // Filter by supervisor's group code
                ->count();
        } else {
            $this->agentCount = 0; // If no supervisor group, set agent count to 0
        }
    }

    public function render()
    {
        return view('livewire.supervisor.supervisor-dashboard', [
            'supervisorGroup' => $this->supervisorGroup, // Pass it to the view explicitly (optional)
        ]);
    }
}
