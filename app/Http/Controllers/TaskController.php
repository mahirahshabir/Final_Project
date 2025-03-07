<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Phase;
use App\Models\Project;
use Dom\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // For query logging


class TaskController extends Controller
{
    function create(){
        $projects = Project::all(); // Fetch all projects for selection
        return view('tasks.create', compact('projects'));
    }


}