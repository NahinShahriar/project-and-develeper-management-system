<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\UserManageController;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

/** 
 * Routes for guests only (not logged in)
 * Add login page GET route so user can see login form
 */
    Route::get('password/reset/{token}', [UserController::class, 'create'])->name('password.reset');
    Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
    Route::post('/dashboard', [UserController::class, 'login'])->name('login');

    // Password reset form & submit
   
    Route::post('password/reset', [UserController::class, 'password_update'])->name('password.update');
});

/** 
 * Routes for logged-in users
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/search', [TaskController::class, 'index'])->name('task.search');

    // Task CRUD
    Route::get('/tasks/create', [TaskController::class, 'task_create'])->name('task.create');
    Route::post('/tasks/store', [TaskController::class, 'task_store'])->name('task.store');
    Route::get('/tasks/edit/{id}', [TaskController::class, 'task_edit'])->name('task.edit');
    Route::put('/tasks/update/{id}', [TaskController::class, 'task_update'])->name('task.update');
    Route::post('/tasks/status_update/{id}', [UserController::class, 'task_update'])->name('status.update');
    Route::post('/tasks/delete/{id}', [TaskController::class, 'task_delete'])->name('task.delete');

    // Projects and users management
    Route::resource('projects', ProjectController::class);
    Route::resource('users', UserManageController::class);

    // Logout route (usually should be inside auth)
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    //
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/change-password', [UserController::class, 'showChangePasswordForm'])->name('change_password');
     Route::post('/profile/change-password', [UserController::class, 'ChangePassword'])->name('password.change');


});
