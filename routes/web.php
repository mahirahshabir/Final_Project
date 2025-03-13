<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\PhaseController;
use App\Models\CustomField;

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Task Routes
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // Allow GET requests
Route::post('/update-task-phase', [TaskController::class, 'updateTaskPhase'])->name('update-task-phase');
Route::get('/tasks/{taskId}', [TaskController::class, 'showTaskDashboard'])->name('tasks.dashboard');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::post('/tasks/store',[TaskController::class,'store'])->name('tasks.store');


// Project Routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('projects/store',[ProjectController::class,'store'])->name('projects.store');


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

// Registered Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('store');


// Phases Route
Route::post('/phases', [PhaseController::class, 'store'])->name('phases.store');
Route::get('/phases/{id}/edit', [PhaseController::class, 'edit'])->name('phases.edit');
Route::get('/phases/show',[PhaseController::class,'show'])->name('phases.show');
Route::put('/phases/{id}', [PhaseController::class, 'update'])->name('phases.update');
Route::delete('/phases/{id}', [PhaseController::class, 'destroy'])->name('phases.destroy');

// Custom Field Routes
Route::get('/custom-fields', [CustomFieldController::class, 'index'])->name('custom-fields.index');
Route::post('/custom-fields', [CustomFieldController::class, 'store'])->name('custom-fields.store');
Route::get('/custom-fields/{id}/edit', [CustomFieldController::class, 'edit'])->name('custom-fields.edit');
Route::put('/custom-fields/{id}', [CustomFieldController::class, 'update'])->name('custom-fields.update');
Route::delete('/custom-fields/{id}', [CustomFieldController::class, 'destroy'])->name('custom-fields.destroy');

// Route::get('/',function(){
// return view('welcome');
// });

