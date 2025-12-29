<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\WarningController;
use App\Http\Controllers\Api\ScheduleApiController;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::get('/register-form', [AuthApiController::class, 'showregister']); 
Route::get('/login-form', [AuthApiController::class, 'showLogin']);     

Route::apiResource('posts', PostApiController::class)->only(['index', 'show']);
Route::apiResource('portfolios', PortfolioApiController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', function (Request $request) { 
        return $request->user();
    });

    Route::apiResource('posts', PostApiController::class)->except(['index', 'show']); 
    Route::apiResource('portfolios', PortfolioApiController::class)->except(['index', 'show']); 
    Route::apiResource('schedules', ScheduleApiController::class); 
    Route::apiResource('warnings', WarningController::class); 

    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
});