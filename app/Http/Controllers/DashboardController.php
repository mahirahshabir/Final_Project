<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
       $users = User::all(); // Fetch all users
    $projects = Project::all(); // Fetch all projects
    $tasks = Task::all(); // Fetch all tasks

    return view('dashboard', compact('users', 'projects', 'tasks'));
    }
}
