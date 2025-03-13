<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Phase;
use App\Models\Project;
use Dom\Comment;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // For query logging


class TaskController extends Controller
{
    function create(){
        $projects = Project::all();
        return view('tasks.create',compact('projects') );
    }
    function showTaskDashboard($id){
        // $task = Task::findOrFail($id);
        $users = User::all();
        $task = Task::findOrFail($id);
        if (!$task) {
           abort(404, 'Task not found');
       }
    return view('tasks.task-dashboard', compact('task','users'));
    }
    // public function show($id) {
    //     $task = Task::findOrFail($id); // ✅ Single task
    //     return view('tasks.task-dashboard', compact('task'));
    // }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'project_id' => 'nullable|numeric'
        ]);

        // Get the first phase
        $firstPhase = Phase::orderBy('id', 'asc')->first();
        if (!$firstPhase) {
            return redirect()->back()->with('error', 'No phases available in the system!');
        }

        // Create the task
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'project_id' => $request->project_id,
            'created_by' => Auth::id(),
        ]);

        // Attach task to the first phase with `created_by`
        $task->phases()->attach($firstPhase->id, [
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Task created and assigned to the first phase successfully!');
    }




    public function updateTaskPhase(Request $request) {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'phase_id' => 'required|exists:phases,id',
        ]);

        Log::info('Request Data:', $request->all());

        $task = Task::find($request->task_id);

        if ($task) {
            Log::info('Moving Task ID: ' . $request->task_id . ' to Phase ID: ' . $request->phase_id);

            // Sync to update `task_phase` without deleting previous associations
            $task->phases()->sync([
                $request->phase_id => [
                    'created_by' => Auth::id(),
                    'updated_at' => now(),
                ]
            ]);

            return response()->json(['success' => true, 'message' => 'Task moved successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Task not found!'], 404);
    }






}
