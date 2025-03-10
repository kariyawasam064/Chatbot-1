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
            ->select('users.name', 'users.emp_id', 'users.email', \DB::raw('GROUP_CONCAT(reporter_group.group_code) as `group`'))
            ->groupBy('users.emp_id', 'users.name', 'users.email')
            ->get();

        // Prepare the reporters data
        $reporters = $reporters->map(function ($reporter) {
            return (object) [
                'name' => $reporter->name,
                'emp_id' => $reporter->emp_id,
                'email' => $reporter->email,
                'group' => $reporter->group, // Group codes are already concatenated
            ];
        });


    $groups = Group::all();

    return view('livewire.admin.admin-reporter-manager', compact('groups', 'reporters'));
}



}
