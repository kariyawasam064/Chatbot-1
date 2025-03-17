<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Skill;


class AdminSkillManager extends Component
{
    public $skills;
    public $name;
    public $language;
    public $description;
    public $skillId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'language' => 'required|string',
        'description' => 'required|string',
    ];

    public function mount()
    {
        $this->loadSkills();
    }

    public function loadSkills()
    {
        $this->skills = Skill::all();
    }

    public function render()
    {
        return view('livewire.admin.admin-skill-manager')->layout('layouts.app');

    }

    
    
}
