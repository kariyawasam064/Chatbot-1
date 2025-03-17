<?php

namespace App\Livewire\Admin;

use App\Models\Group;
use Livewire\Component;

class AdminGroupManager extends Component
{
    public $groups;
    public $group_name;
    public $group_code;
    public $address;
    public $contact_number;
    public $group_id;

    protected $rules = [
        'group_name' => 'required|string|max:255',
        'groupCode' => 'required|string|max:4|unique:group',
        'address' => 'required|string|max:255',
        'contact_number' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadGroups();
    }

    public function loadGroups()
    {
        $this->groups = Group::all();
    }
    
    public function render()
    {
        return view('livewire.admin.admin-group-manager')->layout('layouts.app');
    }
}
