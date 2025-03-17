<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Reporter;
use App\Models\ReporterGroup;
use App\Models\Group;
use Livewire\Component;

class AdminReporterManager extends Component
{

    public function render()
{
    $reporters = User::where('role', 'reporter')
        ->join('reporter_group', 'users.emp_id', '=', 'reporter_group.emp_id')
        ->join('group', 'group.group_code', '=', 'reporter_group.group_code') // Optional if you need group details
        ->select('users.name', 'users.emp_id', 'users.email', 'reporter_group.group_code')
        ->get()
        ->groupBy('emp_id'); // Group by emp_id

    // Prepare the reporters data to combine group codes
    $reporters = $reporters->map(function ($reporterGroup) {
        return (object) [
            'name' => $reporterGroup->first()->name,
            'emp_id' => $reporterGroup->first()->emp_id,
            'email' => $reporterGroup->first()->email,
            'group' => $reporterGroup->pluck('group_code')->implode(', '), // Join group codes with a comma
        ];
    });

    $groups = Group::all();

    return view('livewire.admin.admin-reporter-manager', compact('groups', 'reporters'));
}



}
