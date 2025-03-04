<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log; //  Corrected import
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    // Store new task
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phase_id' => 'required|exists:phases,id',
    ]);

    try {
        $task = Task::create([
            'name' => $request->name,
            'phase_id' => $request->phase_id,
        ]);

        return response()->json(['success' => true, 'task' => $task]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    public function updateTaskPhase(Request $request)
{
    $validated = $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'phase_id' => 'required|exists:phases,id',
    ]);

    // Check if the task already has a phase assigned
    $existingTaskPhase = DB::table('task_phase')
        ->where('task_id', $request->task_id)
        ->first();

    if ($existingTaskPhase) {
        // Update the existing phase record
        DB::table('task_phase')
            ->where('task_id', $request->task_id)
            ->update([
                'phase_id' => $request->phase_id,
                'updated_at' => now(),
            ]);
    } else {
        // Insert a new record if task has no phase assigned
        DB::table('task_phase')->insert([
            'task_id' => $request->task_id,
            'phase_id' => $request->phase_id,
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return response()->json(['success' => true]);
}
public function index()
{
    $tasks = Task::all()->groupBy('status');
    return view('dashboard', compact('tasks'));
}


public function show($id)
{
    $task = Task::with(['phases', 'assignee', 'comments.user'])->findOrFail($id);
    return view('tasks.task-dashboard', compact('task'));
}




}
