<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index'); 
    }

    public function create()
    {
        return view('projects.create'); 
}

    public function assignUsers(Project $project) {
    $users = User::all();
    return view('projects.assign', compact('project', 'users'));
}

}

