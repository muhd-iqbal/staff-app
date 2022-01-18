<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemStatusController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TopLeaveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [UserController::class, 'show']);
    Route::patch('/profile/update/{user}', [UserController::class, 'update']);
    Route::get('/profile/upload', [PhotoController::class, 'create']);
    Route::patch('/profile/upload/{user}', [PhotoController::class, 'update']);
    Route::get('/staff', [StaffController::class, 'index']);

    Route::get('/leaves', [LeaveController::class, 'index']);
    Route::get('/leaves/create', [LeaveController::class, 'create']);
    Route::post('/leaves/create/{user}', [LeaveController::class, 'store']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/location/{location}', [OrderController::class, 'index_location']);
    Route::get('/orders/create', [OrderController::class, 'create']);
    Route::post('/orders/create', [OrderController::class, 'insert']);
    Route::get('/orders/view/{order}', [OrderController::class, 'view']);
    Route::get('/orders/view/{order}/edit', [OrderController::class, 'edit']);
    Route::get('/orders/view/{order}/pickup', [OrderController::class, 'pickup']);
    Route::patch('/orders/pickup/{order}', [OrderController::class, 'update_pickup']);
    Route::patch('/orders/edit/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}/delete', [OrderController::class, 'delete']);
    Route::patch('/orders/view/{order}/mark-done', [OrderController::class, 'update_done']);
    Route::patch('/orders/view/{order}/mark-undone', [OrderController::class, 'update_undone']);
    Route::get('/orders/no-pickup', [OrderController::class, 'index_nopickup']);

    Route::get('/orders/{order}/add-item', [OrderItemController::class, 'create']);
    Route::post('/orders/{order}/add-item', [OrderItemController::class, 'insert']);
    Route::get('/orders/item/{item}', [OrderItemController::class, 'view']);
    Route::get('/orders/item/{item}/edit', [OrderItemController::class, 'edit']);
    Route::patch('/orders/item/{item}/update', [OrderItemController::class, 'update']);
    Route::delete('/orders/item/{item}/delete', [OrderItemController::class, 'delete']);
    Route::patch('/orders/item/{item}/user', [OrderItemController::class, 'update_user']);
    Route::patch('/orders/item/{item}/status', [OrderItemController::class, 'update_status']);
    Route::patch('/orders/item/{item}/takeover', [OrderItemController::class, 'update_takeover']);
    Route::post('/orders/item/{item}/foto', [OrderItemController::class, 'update_photo']);
    Route::post('/orders/item/picture/{picture}/del', [OrderItemController::class, 'delete_photo']);

    Route::post('/orders/item/{item}/design', [ItemStatusController::class, 'update_design']);
    Route::post('/orders/item/{item}/approved', [ItemStatusController::class, 'update_approved']);
    Route::post('/orders/item/{item}/approved-guar', [ItemStatusController::class, 'update_approved_guar']);
    Route::post('/orders/item/{item}/approved-production', [ItemStatusController::class, 'update_approved_prod']);
    Route::post('/orders/item/{item}/approved-subcon', [ItemStatusController::class, 'update_approved_sub']);
    Route::post('/orders/item/{item}/update-subcon', [OrderItemController::class, 'update_sub']);
    // Route::post('/orders/item/{item}/printing', [ItemStatusController::class, 'update_printing']);
    Route::post('/orders/item/{item}/done', [ItemStatusController::class, 'update_done']);
    Route::get('/orders/item/status/{status}', [ItemStatusController::class, 'show_status']);
    Route::get('/orders/item/status/is_approved/{production}', [ItemStatusController::class, 'show_production']);

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit']);
    Route::patch('/customer/{customer}/edit', [CustomerController::class, 'update']);

    Route::get('/to-do', [TaskController::class, 'index']);
    Route::get('/staff/prev-works', [TaskController::class, 'previous']);
    Route::get('/print', [TaskController::class, 'view_print']);
    Route::get('/print-list', [TaskController::class, 'print_print']);
    Route::get('/items/print-sticker/{item}', [TaskController::class, 'print_sticker']);
    Route::get('/print/all-stickers', [TaskController::class, 'print_allstickers']);
    Route::get('/view-designer', [TaskController::class, 'view_designer']);

});

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/staff/show/{user}', [StaffController::class, 'show']);
    Route::patch('/staff/active/{user}', [StaffController::class, 'update']);

    Route::get('/leaves/approval', [LeaveController::class, 'show']);
    Route::patch('/leaves/approval/{leave}', [LeaveController::class, 'update']);
    Route::delete('/leaves/approval/{leave}', [LeaveController::class, 'delete']);

    Route::get('/top/leave-types', [LeaveTypeController::class, 'index']);
    Route::patch('/top/leave-types/{type}', [LeaveTypeController::class, 'update']);
    Route::get('suppliers/create', [SupplierController::class, 'create']);
    Route::post('suppliers/create', [SupplierController::class, 'store']);

});

Route::group(['middleware' => ['auth', 'owner']], function () {

    Route::get('/top/leaves/approval', [TopLeaveController::class, 'show']);
    Route::patch('/top/leaves/approval/{leave}', [TopLeaveController::class, 'update']);
    Route::delete('/top/leaves/approval/{leave}', [TopLeaveController::class, 'delete']);

});

Route::get('/artisan-clear', function() {
    Artisan::call('cache:clear');
    // Artisan::call('route:clear');
    Artisan::call('config:clear');
    // Artisan::call('view:clear');
    return "Cache is cleared";
});

require __DIR__ . '/auth.php';
