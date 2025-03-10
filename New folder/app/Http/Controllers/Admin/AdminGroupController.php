<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class AdminGroupController extends Controller
{
    // Store a new group
    public function store(Request $request){
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_code' => 'required|string|max:8|unique:group',
            'address' => 'required|string|max:255',
            'contact_number' => ['required','numeric','digits:10', 
    ],
], [
    'contact_number.numeric' => 'The contact number must contain only digits.', // Message for non-numeric characters
    'contact_number.digits' => 'The contact number must be exactly 10 digits.', // Message for incorrect digit length
]);
    
        Group::create($validated);
        return redirect()->route('admin.group')->with('success', 'Group added successfully!');
    }
    
    // Update an existing group
    public function update(Request $request, $id){
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_code' => 'required|string|max:8|unique:group,group_code,' . $id,
            'address' => 'required|string|max:255',
            'contact_number' => ['required','numeric','digits:10', 
        ],
    ], [
        'contact_number.numeric' => 'The contact number must contain only digits.', // Message for non-numeric characters
        'contact_number.digits' => 'The contact number must be exactly 10 digits.', // Message for incorrect digit length
    ]);
    
        $group = Group::findOrFail($id);
        $group->update($validated);
        return redirect()->route('admin.group')->with('success', 'Group updated successfully!');
    }     
    
    // Remove the specified group from storage
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.group')->with('success', 'Group deleted successfully!');
    }

    public function search(Request $request)
   {
    $groups = Group::where('group_code', $request->group_code)->get()->map(function ($group) {
        return [
            'id' => $group->id,
            'group_name' => $group->group_name ?? '',
            'group_code' => $group->group_code ?? '',
            'address' => $group->address ?? '',
            'contact_number' => $group->contact_number ?? '',
        ];
    });

    if ($groups->isEmpty()) {
        return response()->json([], 200);
    }

    return response()->json($groups, 200);
    }

    
}

