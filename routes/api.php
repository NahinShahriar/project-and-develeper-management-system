<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
    Route::middleware(['auth:sanctum','admin'])->group(function()
{

     Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    //  Route::get('/seetasks/{id}', [TaskController::class, 'show_tasks']);
    Route::get('/seetask/{id}', [TaskController::class, 'show_task']);

    Route::get('/tasks/search', [TaskController::class, 'index'])->name('task.search');

    // Task CRUD
    Route::get('/tasks/create', [TaskController::class, 'task_create'])->name('task.create');
    Route::post('/tasks/store', [TaskController::class, 'task_store'])->name('task.store');
    Route::get('/tasks/edit/{id}', [TaskController::class, 'task_edit'])->name('task.edit');
    Route::put('/tasks/update/{id}', [TaskController::class, 'task_update'])->name('task.update');
    Route::post('/tasks/status_update/{id}', [UserController::class, 'task_update'])->name('status.update');
    Route::post('/tasks/delete/{id}', [TaskController::class, 'task_delete'])->name('task.delete');

});


   
