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


    public function store(Request $request)
    {
        Log::info('Task creation request received:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task = Task::create($validated);

        if ($task) {
            Log::info('Task successfully created:', $task->toArray());
        } else {
            Log::error('Task creation failed.');
        }

        // return response()->json(['success' => (bool) $task, 'task' => $task]);
    }




    // Update task phase
    public function updateTaskPhase(Request $request)
    {
        try {
            Log::info('Update Task Phase Request:', $request->all());

            $task = Task::find($request->task_id);
            if (!$task) {
                Log::error("Task not found with ID: " . $request->task_id);
                return response()->json(['success' => false, 'message' => 'Task not found'], 404);
            }

            $newPhase = Phase::find($request->phase_id);
            if (!$newPhase) {
                Log::error("Phase not found with ID: " . $request->phase_id);
                return response()->json(['success' => false, 'message' => 'Phase not found'], 404);
            }

            // Get current phase
            $oldPhase = $task->phases()->first();
            if ($oldPhase) {
                Log::info("Detaching task {$task->id} from phase {$oldPhase->id}");
                $task->phases()->detach($oldPhase->id);
            }

            // Attach task to new phase
            Log::info("Attaching task {$task->id} to phase {$newPhase->id}");
            $task->phases()->attach($newPhase->id);

            return response()->json(['success' => true, 'message' => 'Task phase updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error updating task phase:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to update task phase'], 500);
        }
    }




    // Display tasks grouped by status
    public function index()
    {
        $phases = Phase::with('tasks')->get();
        return view('dashboard', compact('phases'));
    }

    // Show available assignees
    public function showAssignees()
    {
        $assignees = User::all(); // Ensure all users are retrieved
        return view('assignees.index', compact('assignees'));
    }

    // Show task details
    public function show($id)
    {
        $task = Task::with(['phases', 'assignee', 'comments.user'])->findOrFail($id); // Ensure it exists
        $users = User::all();  // Get all users for the dropdown
        $phases = Phase::all(); // Get all phases

        return view('tasks.task-dashboard', compact('task', 'users', 'phases'));
    }

    // Assign user to a task
    public function assignUser(Request $request, $id)
    {
        $request->validate([
            'assignee_id' => 'nullable|exists:users,id', // Allow unassigning
        ]);

        $task = Task::findOrFail($id);
        $task->assignee_id = $request->assignee_id; // Assign user
        $task->save();

        return back()->with('success', 'Assignee updated successfully!');
    }


    // Assign phases to a task
    public function assignPhase(Request $request, $id)
    {
        $request->validate([
            'phase_id' => 'required|array', // Expect an array of phase IDs
            'phase_id.*' => 'exists:phases,id', // Ensure all values exist
        ]);

        $task = Task::findOrFail($id);
        $task->phases()->sync($request->phase_id); // Sync multiple phases

        return back()->with('success', 'Phases updated successfully!');
    }

    public function addComment(Request $request, Task $task)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Create the comment
        $comment = new Comment([
            'content' => $request->input('content'),
            // 'user_id' => auth()->id(), // Assign the comment to the currently authenticated user
        ]);

        // Associate the comment with the task
        // $task->comments()->save($comment);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

}

