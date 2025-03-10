<?php
namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supervisor;
use App\Models\User;

class SupervisorController extends Controller
{
    public function showProfile()
    {
        // Get the logged-in user's data
        $user = auth()->user();
        
        // Get supervisor group details
        $supervisor = Supervisor::where('emp_id', $user->emp_id)->first();

        // Return the profile view with user and supervisor data
        return view('supervisor.profile', compact('user', 'supervisor'));
    }
}
