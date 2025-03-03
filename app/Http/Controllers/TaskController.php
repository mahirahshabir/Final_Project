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

    // Update task's phase when dragged
    public function updatePhase(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'phase_id' => 'required|integer',
        ]);

        $task = Task::find($request->task_id);
        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found.'], 404);
        }

        $task->update(['phase_id' => $request->phase_id]);

        return response()->json(['success' => true]);
    }
public function index()
{
    $tasks = Task::all()->groupBy('status');
    return view('dashboard', compact('tasks'));
}
public function updateTaskPhase(Request $request)
{
    $validated = $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'phase_id' => 'required|exists:phases,id',
    ]);

    // Insert new record with created_by
    DB::table('task_phase')->insert([
        'task_id' => $request->task_id,
        'phase_id' => $request->phase_id,
        'created_by' => Auth::id(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['success' => true]);
}


}
