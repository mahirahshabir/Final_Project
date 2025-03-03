<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TaskController;

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

