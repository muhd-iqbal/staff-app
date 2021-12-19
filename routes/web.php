<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TopLeaveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [UserController::class, 'show']);
    Route::patch('profile/update/{user}', [UserController::class, 'update']);
    Route::get('profile/upload', [PhotoController::class, 'create']);
    Route::patch('profile/upload/{user}', [PhotoController::class, 'update']);
    Route::get('staff', [StaffController::class, 'index']);

    Route::get('leaves', [LeaveController::class, 'index']);
    Route::get('leaves/create', [LeaveController::class, 'create']);
    Route::post('leaves/create/{user}', [LeaveController::class, 'store']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/create', [OrderController::class, 'create']);
    Route::post('/orders/create', [OrderController::class, 'insert']);
    Route::get('/orders/view/{order}', [OrderController::class, 'view']);
    Route::patch('/orders/view/{order}/mark-done', [OrderController::class, 'update_done']);

    Route::get('/orders/{order}/add-item', [OrderItemController::class, 'create']);
    Route::post('/orders/{order}/add-item', [OrderItemController::class, 'insert']);
    Route::get('/orders/item/{item}', [OrderItemController::class, 'view']);
    Route::patch('/orders/item/{item}/user', [OrderItemController::class, 'update_user']);
    Route::patch('/orders/item/{item}/status', [OrderItemController::class, 'update_status']);
    Route::patch('/orders/item/{item}/takeover', [OrderItemController::class, 'update_takeover']);
    Route::post('/orders/item/{item}/foto', [OrderItemController::class, 'update_photo']);

    Route::get('to-do', [TaskController::class, 'index']);

});

Route::group(['middleware' => ['auth', 'admin']], function () {
    //
    Route::get('staff/show/{user}', [StaffController::class, 'show']);
    // Route::get('staff/resume/{user}', [StaffController::class, 'resume']);
    Route::patch('staff/active/{user}', [StaffController::class, 'update']);

    Route::get('leaves/approval', [LeaveController::class, 'show']);
    Route::patch('leaves/approval/{leave}', [LeaveController::class, 'update']);
    Route::delete('leaves/approval/{leave}', [LeaveController::class, 'delete']);

    Route::get('top/leave-types', [LeaveTypeController::class, 'index']);
    Route::patch('top/leave-types/{type}', [LeaveTypeController::class, 'update']);

});

Route::group(['middleware' => ['auth', 'owner']], function () {

    Route::get('top/leaves/approval', [TopLeaveController::class, 'show']);
    Route::patch('top/leaves/approval/{leave}', [TopLeaveController::class, 'update']);
    Route::delete('top/leaves/approval/{leave}', [TopLeaveController::class, 'delete']);

});



require __DIR__ . '/auth.php';
