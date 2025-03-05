<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PhaseController;


// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/update-task-phase', [TaskController::class, 'updateTaskPhase'])->name('update-task-phase');

Route::post('/tasks/store', [TaskController::class, 'store'])->name('store-task');

// Protected Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout'); //  Moved inside the same group
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route::get('/',function(){
// return view('welcome');
// });

// phase routes


Route::get('/phases', [PhaseController::class, 'index']);
Route::get('/phases/create', [PhaseController::class, 'create'])->name('phases.create');
Route::delete('/phases/{id}', [PhaseController::class, 'destroy']);
Route::post('/phases/reorder', [PhaseController::class, 'reorder']);
Route::post('/phases', [PhaseController::class, 'store'])->name('phases.store');

