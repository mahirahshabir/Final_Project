<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Phase;

class TaskController extends Controller
{
    // Store a new task
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

    // Update task phase
    public function updateTaskPhase(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'phase_id' => 'required|exists:phases,id',
        ]);

        $task = Task::findOrFail($request->task_id);
        $task->phases()->sync([$request->phase_id]); // Ensure it's an array

        return response()->json(['success' => true]);
    }

    // Display tasks grouped by status
    public function index()
    {
        $tasks = Task::all()->groupBy('status');
        return view('dashboard', compact('tasks'));
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
            'user_id' => auth()->id(), // Assign the comment to the currently authenticated user
        ]);

        // Associate the comment with the task
        $task->comments()->save($comment);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function getStatus($id)
{
    $task = Task::with('phases')->findOrFail($id);
    $latestPhase = $task->phases->sortByDesc('created_at')->first();
    
    return response()->json([
        'status' => $latestPhase ? $latestPhase->status : 'Not Set'
    ]);
}

}

