<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reporter;
use App\Models\Group;
use App\Models\ReporterGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminReporterController extends Controller
{
// Store Method to add a new reporter
public function store(Request $request)
{
    $validated = $request->validate([
        'emp_id' => 'required|unique:users,emp_id', // Ensure emp_id is unique in the users table
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // Ensure email is unique in the users table
        'group_code' => 'required|array', // group_code must be an array
        'group_code.*' => [
            'exists:group,group_code', // Ensure group_code exists in the group table
            function ($attribute, $value, $fail) {
                if (\App\Models\ReporterGroup::where('group_code', $value)->exists()) {
                    $fail("The group '{$value}' is already assigned to another reporter.");
                }
            }
        ],
        'password' => 'required|confirmed|min:8',
    ]);

    // Create user
    $user = User::create([
        'emp_id' => $validated['emp_id'],
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($request->password),
        'role' => 'reporter',
    ]);

    // Add user to selected groups
    foreach ($validated['group_code'] as $group_code) {
        ReporterGroup::create([
            'emp_id' => $user->emp_id,
            'group_code' => $group_code,
        ]);
    }

    return redirect()->route('admin.reporter')->with('success', 'Reporter added successfully.');
}


public function edit($emp_id)
    {
        $reporter = User::where('emp_id', $emp_id)->firstOrFail();
        $groups = ReporterGroup::where('emp_id', $emp_id)->pluck('group_code')->toArray();

        return response()->json([
            'reporter' => $reporter,
            'groups' => $groups,
        ]);
    }

    public function update(Request $request, $emp_id)
{
    // Validate the incoming data
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'groups' => 'required|array', // Groups should be an array
        'groups.*' => [
            'exists:group,group_code', // Ensure group_code exists in the group table
            function ($attribute, $value, $fail) use ($emp_id) {
                // Check if the group_code is already assigned to another reporter (excluding current emp_id)
                if (\App\Models\ReporterGroup::where('group_code', $value)
                    ->where('emp_id', '!=', $emp_id)
                    ->exists()) {
                    $fail("The group '{$value}' is already assigned to another reporter.");
                }
            }
        ]
    ]);

    // Find the reporter using emp_id
    $user = User::where('emp_id', $emp_id)->firstOrFail();

    // Update user details
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Check if validation passed before modifying group associations
    if ($request->has('groups')) {
        // Delete old group associations for this reporter (Only if validation passes)
        ReporterGroup::where('emp_id', $emp_id)->delete();

        // Add new group associations
        foreach ($request->groups as $group_code) {
            ReporterGroup::create([
                'emp_id' => $emp_id,
                'group_code' => $group_code,
            ]);
        }
    }

    // Redirect with success message
    return redirect()->route('admin.reporter')->with('success', 'Reporter updated successfully.');
}
    

    
    public function destroy($emp_id)
{

    User::where('emp_id', $emp_id)->delete();
    ReporterGroup::where('emp_id', $emp_id)->delete();

    return redirect()->route('admin.reporter')->with('success', 'Reporter deleted successfully.');
}

public function filter(Request $request)
{
    // Update the query to target reporters
    $query = User::where('role', 'reporter')
        ->join('reporter_group', 'users.emp_id', '=', 'reporter_group.emp_id')
        ->select('users.name', 'users.emp_id', 'users.email', 'reporter_group.group_code as group');

    // Filter by Employee ID if provided
    if ($request->filled('empID')) {
        $query->where('users.emp_id', $request->empID);
    }

    // Filter by Group if provided
    if ($request->filled('group')) {
        $query->where('reporter_group.group_code', $request->group);
    }

    // Fetch the reporters based on the query
    $reporters = $query->get();

    // Return reporters as JSON response
    return response()->json($reporters);
}
   
}
