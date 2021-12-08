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

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('profile', [UserController::class, 'show'])->middleware(['auth']);
Route::patch('profile/update/{user}', [UserController::class, 'update'])->middleware(['auth']);
Route::get('profile/upload', [PhotoController::class, 'create'])->middleware(['auth']);
Route::patch('profile/upload/{user}', [PhotoController::class, 'update'])->middleware(['auth']);

Route::get('staff', [StaffController::class, 'index'])->middleware(['auth']);
Route::get('staff/show/{user}', [StaffController::class, 'show'])->middleware('admin');
// Route::get('staff/resume/{user}', [StaffController::class, 'resume']);
Route::patch('staff/active/{user}', [StaffController::class, 'update'])->middleware('admin');

Route::get('leaves', [LeaveController::class, 'index'])->middleware(['auth']);
Route::get('leaves/create', [LeaveController::class, 'create'])->middleware(['auth']);
Route::post('leaves/create/{user}', [LeaveController::class, 'store'])->middleware(['auth']);
Route::get('leaves/approval', [LeaveController::class, 'show'])->middleware(['auth']);
Route::patch('leaves/approval/{leave}', [LeaveController::class, 'update'])->middleware(['auth']);
Route::delete('leaves/approval/{leave}', [LeaveController::class, 'delete'])->middleware(['auth']);

Route::get('top/leaves/approval', [TopLeaveController::class, 'show'])->middleware('owner');
Route::patch('top/leaves/approval/{leave}', [TopLeaveController::class, 'update'])->middleware('owner');
Route::delete('top/leaves/approval/{leave}', [TopLeaveController::class, 'delete'])->middleware('owner');

Route::get('top/leave-types', [LeaveTypeController::class, 'index'])->middleware('admin');
Route::patch('top/leave-types/{type}', [LeaveTypeController::class, 'update'])->middleware('admin');

Route::get('/orders', [OrderController::class, 'index'])->middleware(['auth']);
Route::get('/orders/create', [OrderController::class, 'create'])->middleware(['auth']);
Route::post('/orders/create', [OrderController::class, 'insert'])->middleware(['auth']);
Route::get('/orders/view/{order}', [OrderController::class, 'view'])->middleware(['auth']);
Route::patch('/orders/view/{order}/mark-done', [OrderController::class, 'update_done'])->middleware(['auth']);

Route::get('/orders/{order}/add-item', [OrderItemController::class, 'create'])->middleware(['auth']);
Route::post('/orders/{order}/add-item', [OrderItemController::class, 'insert'])->middleware(['auth']);
Route::get('/orders/item/{item}', [OrderItemController::class, 'view'])->middleware(['auth']);
Route::patch('/orders/item/{item}/user', [OrderItemController::class, 'update_user'])->middleware(['auth']);
Route::patch('/orders/item/{item}/status', [OrderItemController::class, 'update_status'])->middleware(['auth']);
Route::patch('/orders/item/{item}/takeover', [OrderItemController::class, 'update_takeover'])->middleware(['auth']);

Route::get('to-do', [TaskController::class, 'index'])->middleware(['auth']);

require __DIR__ . '/auth.php';
