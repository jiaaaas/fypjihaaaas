<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::get('/leave/leave_status', [LeaveController::class, 'leave_status']);
Route::post('leave/leave_form', [LeaveController::class, 'leave_form']);