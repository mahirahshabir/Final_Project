<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Phase;


class DashboardController extends Controller
{
    public function index()
    {
    $phases = Phase::with('tasks')->get();
    $users = User::all(); // Fetch all users
    $projects = Project::all(); // Fetch all projects
    $tasks = Task::all(); // Fetch all tasks

    return view('dashboard', compact('phases','users', 'projects', 'tasks'));
    }
}
