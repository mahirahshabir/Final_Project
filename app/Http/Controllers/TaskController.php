<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Phase;

class TaskController extends Controller
{
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
        $task = Task::find($request->task_id);
        $task->phases()->sync($request->phase_id);

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $tasks = Task::all()->groupBy('status');
        return view('dashboard', compact('tasks'));
    }

    public function show(Task $task)
    {
        $task->load(['phases', 'assignee', 'comments.user']);
        $users = User::all();
        $phases = Phase::all();
        return view('tasks.task-dashboard', compact('task', 'users', 'phases'));
    }

    public function assignUser(Request $request, Task $task)
    {
        $task->assignee_id = $request->assignee_id;
        $task->save();
        return back()->with('success', 'Assignee updated successfully!');
    }

    public function assignPhase(Request $request, Task $task)
    {
        $task->phases()->sync($request->phase_id);
        return back()->with('success', 'Phases updated successfully!');
    }
}