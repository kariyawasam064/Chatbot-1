<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Supervisor;
use App\Models\Group;
use Livewire\Component;

class AdminSupervisorManager extends Component
{   
    public $search;
    public $supervisors = [];
    public $groups = [];
    public $emp_id = '';
    public $name = '';
    public $email = '';
    public $group = '';
    public $passwordSupervisorUpdate = '';
    public $confirmPasswordSupervisorUpdate = '';

    // Load the initial data when the component is mounted
    public function mount()
    {
        // Load all supervisors and groups to populate the dropdowns
        $this->supervisors = Supervisor::with('user', 'group')->get();
        $this->groups = Group::all();
    }

    
    // Load supervisor data for the modal
    public function fetchSupervisorData($id)
{
    $supervisor = Supervisor::with('user', 'group')->findOrFail($id);

    $this->emp_id = $supervisor->user->emp_id;
    $this->name = $supervisor->user->name;
    $this->email = $supervisor->user->email;
    $this->group = $supervisor->group_code;
}

 
    
public function render()
{
    // Query the Supervisor table and apply filters based on inputs
    $supervisors = Supervisor::with(['user', 'group'])
        ->when($this->emp_id, function ($query) {
            $query->whereHas('user', function ($query) {
                $query->where('emp_id', 'like', '%' . $this->emp_id . '%');
            });
        })
        ->when($this->group, function ($query) {
            $query->where('group_code', 'like', '%' . $this->group . '%');
        })
        ->when($this->search, function ($query) {
            $query->whereHas('user', function ($userQuery) {
                $userQuery->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('emp_id', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        })
        ->paginate(10);

    // Fetch all groups for dropdown options
    $groups = Group::all();

    // Return the results to the Livewire view
    return view('livewire.admin.admin-supervisor-manager', [
        'supervisors' => $supervisors,
        'groups' => $groups,
        'group' => $this->group,
    ]);
}

}