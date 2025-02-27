<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
public function index()
{
    $tasks = Task::all()->groupBy('status');
    return view('dashboard', compact('tasks'));
}
 public function updateTaskPhase(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->phase_id = $request->phase_id;
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task moved successfully']);
    }
}
