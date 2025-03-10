<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use App\Models\AgentSkill;
use App\Models\Skill;
use App\Models\Group;
use Illuminate\Http\Request;

class SupervisorAgentController extends Controller
{
    public function create()
    {
        // Redirect to the Livewire component without fetching data here
        return view('livewire.supervisor.supervisor-dashboard');
    }

    public function filter(Request $request)
    {
        $query = User::where('role', 'agent')
            ->join('agent', 'users.emp_id', '=', 'agent.emp_id')
            ->select('users.name', 'users.emp_id', 'users.email', 'agent.group_code as group');

        if ($request->filled('empID')) {
            $query->where('users.emp_id', $request->empID);
        }

        if ($request->filled('group')) {
            $query->where('agent.group_code', $request->group);
        }

        $agents = $query->get();

        // Return agents as JSON
        return response()->json($agents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId' => 'required|unique:users,emp_id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'group' => 'required|string',
            'skills' => 'required|array',  // Ensure skills are selected
            'password' => 'required|confirmed|min:8',
        ]);

        // Store user details in the users table
        $user = User::create([
            'emp_id' => $request->employeeId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'agent',  // Assuming the role is agent
        ]);

        // Store the group code in the agent table
        Agent::create([
            'emp_id' => $request->employeeId,
            'group_code' => $request->group,
        ]);

        // Store selected skills in the agent_skill table
        foreach ($request->skills as $skillId) {
            AgentSkill::create([
                'emp_id' => $request->employeeId,
                'skill_id' => $skillId,
            ]);
        }

        // Return a success response or redirect
        return redirect()->route('supervisor.agent')->with('success', 'Agent added successfully');
    }

    public function edit($emp_id)
{
    $agent = User::where('emp_id', $emp_id)->firstOrFail();
    $group = Agent::where('emp_id', $emp_id)->value('group_code');
    $skills = AgentSkill::where('emp_id', $emp_id)->pluck('skill_id')->toArray();

    return view('your-view', [
        'agent' => $agent,
        'group' => $group,
        'skills' => $skills,
    ]);
}


public function update(Request $request, $emp_id)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'skills' => 'required|array',
    ]);

    $user = User::where('emp_id', $emp_id)->firstOrFail();
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // No need to update the group_code, just leave it as is
    // Ensure group_code stays the same by not updating it here

    // Update skills
    AgentSkill::where('emp_id', $emp_id)->delete();
    foreach ($request->skills as $skillId) {
        AgentSkill::create([
            'emp_id' => $emp_id,
            'skill_id' => $skillId,
        ]);
    }

    return redirect()->route('supervisor.agent')->with('success', 'Agent updated successfully.');
}


    // Delete an agent
    public function destroy($emp_id)
    {
        User::where('emp_id', $emp_id)->delete();
        Agent::where('emp_id', $emp_id)->delete();
        AgentSkill::where('emp_id', $emp_id)->delete();

        return redirect()->route('supervisor.agent')->with('success', 'Agent deleted successfully.');
    }

}