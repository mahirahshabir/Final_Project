<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Task Routes
Route::post('/update-task-phase', [TaskController::class, 'updateTaskPhase'])->name('update-task-phase');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('store-task');
Route::post('/task/{id}/update-phase', [TaskController::class, 'updatePhase'])->name('update-phase'); // Added here
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');



// Protected Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');
// Route::get('/',function(){
// return view('welcome');
// });

