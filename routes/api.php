<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->except(['index', 'show'])->middleware(['auth:sanctum', 'throttle:60,1']);
Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped()->only(['index', 'show']);
Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped()->except(['index', 'show'])->middleware('throttle:60,1');