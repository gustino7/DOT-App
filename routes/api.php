<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bookController;

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

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    
    Route::get('/lecturer/{id}', [LecturerController::class, 'get']);
    Route::get('/lecturer', [LecturerController::class, 'getAll']);
    Route::post('/lecturer', [LecturerController::class, 'store']);
    Route::put('/lecturer/{id}', [LecturerController::class, 'update']);
    Route::delete('/lecturer/{id}', [LecturerController::class, 'delete']);

    Route::get('/course/{id}', [CourseController::class, 'get']);
    Route::get('/course', [CourseController::class, 'getAll']);
    Route::post('/course', [CourseController::class, 'store']);
    Route::put('/course/{id}', [CourseController::class, 'update']);
    Route::delete('/course/{id}', [CourseController::class, 'delete']);
});

