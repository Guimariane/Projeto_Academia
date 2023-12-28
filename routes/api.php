<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* Rotas públicas */
Route::post('login', [AuthController::class, 'store']);
Route::post('users', [UserController::class, 'store']);


/* Rotas privadas */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('students', [StudentController::class, 'store']);
    Route::get('students', [StudentController::class, 'index']);

});
