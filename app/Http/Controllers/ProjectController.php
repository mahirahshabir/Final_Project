<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index');
    }

    public function create()
    {

        $users = User::all(); // Fetch all users for the dropdown
        return view('projects.create',compact('users'));
}
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in-progress,completed',
            'manager_id' => 'required|exists:users,id',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->back()->with('success', 'Project created successfully!');
    }

}

