<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Agent;
use App\Models\AgentSkill;
use App\Models\Group;
use App\Models\Skill;

class AdminAgentManager extends Component
{
    public function render()
    {
        $agents = User::where('role', 'agent')
            ->join('agent', 'users.emp_id', '=', 'agent.emp_id')
            ->select('users.name', 'users.emp_id', 'users.email', 'agent.group_code as group')
            ->get();

        $groups = Group::all(); // Retrieve all groups
        $skills = Skill::all(); // Retrieve all skills

        return view('livewire.admin.admin-agent-manager', compact('agents', 'groups', 'skills'));
    }
}
