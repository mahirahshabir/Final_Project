<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
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
