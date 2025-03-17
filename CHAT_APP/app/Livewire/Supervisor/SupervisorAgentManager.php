<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\User;
use App\Models\Agent;
use App\Models\AgentSkill;
use App\Models\Group;
use App\Models\Skill;

class SupervisorAgentManager extends Component
{
    public function render()
    {
        // Retrieve the supervisor's group code from the session
        $supervisorGroup = session('supervisor_group');

        // Fetch agents belonging to the supervisor's group
        $agents = User::where('role', 'agent')
            ->join('agent', 'users.emp_id', '=', 'agent.emp_id') // Assuming the agent table is named 'agents'
            ->where('agent.group_code', $supervisorGroup) // Filter by the supervisor's group code
            ->select('users.name', 'users.emp_id', 'users.email', 'agent.group_code as group')
            ->get();

        // Retrieve all groups and skills
        $groups = Group::all();
        $skills = Skill::all();

        return view('livewire.supervisor.supervisor-agent-manager', compact('agents', 'groups', 'skills'));
    }
}
