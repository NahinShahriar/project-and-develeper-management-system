<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Auth\LoginController;
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

  
    Route::middleware(['auth:sanctum'])->group(function()
{

    Route::get('/tasklist', [TaskController::class, 'index']);
     Route::get('/tasklist/search', [TaskController::class, 'index']);
     Route::post('/logout', [LoginController::class, 'logout']);

});

  Route::post('/login', [LoginController::class, 'login']);
   
