<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

/* Rotas públicas */
Route::post('login', [AuthController::class, 'store']);
Route::post('users', [UserController::class, 'store']);



/* Rotas privadas */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('students', [StudentController::class, 'index']);
    Route::post('students', [StudentController::class, 'store']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::get('students/{id}', [StudentController::class, 'show']);

    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

    Route::post('workouts', [WorkoutController::class, 'store']);
    Route::get('students/{id}/workouts', [WorkoutController::class, 'index']);
    Route::get('students/export/{id}', [WorkoutController::class, 'export']);

    Route::get('dashboard', [DashboardController::class, 'index']);
});
