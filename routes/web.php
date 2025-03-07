<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PhaseController;
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // Allow GET requests

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Task Routes
Route::post('/update-task-phase', [TaskController::class, 'updateTaskPhase'])->name('update-task-phase');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('store-task');
// Route::post('/task/{id}/update-phase', [TaskController::class, 'updatePhase'])->name('update-phase');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{task}/assign', [TaskController::class, 'assignUsers'])->name('tasks.assignUsers');
Route::get('/tasks/{taskId}', [TaskController::class, 'showTaskDashboard'])->name('tasks.dashboard');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); //


// Define the route for adding a comment to a task
Route::post('/tasks/{task}/comments', [TaskController::class, 'addComment'])->name('tasks.addComment');
// Project Routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/projects/{project}/assign', [ProjectController::class, 'assignUsers'])->name('projects.assignUsers');

// Task Assignee Route
Route::post('/tasks/{task}/assign-user', [TaskController::class, 'assignUser'])->name('tasks.assignUser');

// Task Phase Assignment Route
Route::post('/tasks/{task}/assign-phase', [TaskController::class, 'assignPhase'])->name('tasks.assignPhase');


// User (Assignee) Routes
Route::get('/assignees', [UserController::class, 'showAssignees'])->name('assignees.index');
Route::get('/assignees/create', [UserController::class, 'assign'])->name('assignees.create');

// Comment Routes
Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');

// Protected Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Login Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/phases', [PhaseController::class, 'store'])->name('phases.store');
Route::delete('/phases/{id}', [PhaseController::class, 'destroy'])->name('phases.destroy');


// Route::get('/',function(){
// return view('welcome');
// });

