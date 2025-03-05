<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function assignedUsers()
    {
        // Get users who are assigned to at least one task
        $users = User::whereHas('tasks')->get();

        return view('users.assigned', compact('users'));
    }
}
