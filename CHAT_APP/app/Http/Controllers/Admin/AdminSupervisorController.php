<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supervisor;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSupervisorController extends Controller
{
    public function index()
    {    
        $group = ''; // Provide a default value or fetch it dynamically
        $supervisors = Supervisor::with(['user', 'group'])->paginate(10);
        $groups = Group::all(); 
        return view('livewire.admin.admin-supervisor-manager', compact('supervisors', 'group', 'groups'));
    }
   
    public function addSupervisor(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'emp_id' => 'required|unique:users,emp_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'group' => 'required|exists:group,group_code|unique:supervisors,group_code', // Ensure group_code is unique in supervisors table
        ]);
    
        // Create the user (supervisor) entry in the users table
        $user = User::create([
            'emp_id' => $validated['emp_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'supervisor',
        ]);
    
        // Create the supervisor entry and associate it with the user
        Supervisor::create([
            'emp_id' => $user->emp_id,
            'group_code' => $validated['group'],
        ]);
    
        // Return a success message
        return redirect()->route('admin.supervisor.index')->with('success', 'Supervisor added successfully.');
    }
    

    public function edit($id)
    {
        // Fetch supervisor with related user and group
        $supervisor = Supervisor::with('user', 'group')->whereHas('user', function ($query) {
            $query->where('role', 'supervisor'); // Ensure we only fetch supervisors
        })->findOrFail($id);
    
        return response()->json([
            'emp_id' => $supervisor->user->emp_id,    
            'name' => $supervisor->user->name,        
            'email' => $supervisor->user->email,      
            'group_code' => $supervisor->group_code,  
        ]);
    }
    
    public function update(Request $request, $id)
    {
        // Find the supervisor and their related user
        $supervisor = Supervisor::with('user')->findOrFail($id);
    
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $supervisor->user->id,  // Exclude the current user's email
            'group_code' => 'required|exists:group,group_code|unique:supervisors,group_code,' . $supervisor->id, // Ensure group_code is unique across supervisors
        ]);
    
        // Get the user associated with the supervisor
        $user = $supervisor->user;
    
        // Update the user details (name and email)
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
    
        // Update the supervisor's group code
        $supervisor->update([
            'group_code' => $validated['group_code'],
        ]);
    
        // Redirect with success message
        return redirect()->route('admin.supervisor.index')->with('success', 'Supervisor updated successfully.');
    }
    
public function delete($id)
{
    // Fetch the supervisor by ID
    $supervisor = Supervisor::findOrFail($id);
    $user = $supervisor->user; 

    if ($user) {
        // Delete the user record
        $user->delete();
    }

    // Delete the supervisor record
    $supervisor->delete();


    return redirect()->route('admin.supervisor.index')->with('success', 'Supervisor deleted successfully!');
}

public function search(Request $request)
{
    $query = Supervisor::with(['user', 'group']);

    if ($request->filled('emp_id')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('emp_id', $request->emp_id);
        });
    }

    if ($request->filled('group_code')) {
        $query->where('group_code', $request->group_code);
    }

    // Paginate the results
    $supervisors = $query->paginate(10);

    // Fetch all groups to show in the select dropdown
    $groups = Group::all();

    // Return the view with the filtered results
    return view('livewire.admin.admin-supervisor-manager', compact('supervisors', 'groups'));
}

}



