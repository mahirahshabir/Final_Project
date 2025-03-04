<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
     public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ]);

        Comment::create([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

       return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
