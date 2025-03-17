<?php

namespace App\Livewire;

use App\Http\Controllers\AuthController;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Login extends Component
{

    public function render()
    {
        return view('livewire.login');
    }

}
