<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentOrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Support\Facades\Route;


Route::get('agent/login', [AgentController::class, 'login'])->name('agent.login');
Route::post('agent/login', [AgentController::class, 'authenticate']);

Route::group(['prefix' => 'agent', 'middleware' => 'agent'], function () {

    Route::get('', [AgentController::class, 'index']);
    Route::get('logout', [AgentController::class, 'logout'])->name('agent.logout');

    Route::get('/add-order', [AgentOrderController::class, 'index']);
    Route::post('/add-order', [AgentOrderController::class, 'create']);

    Route::get('order/{order}', [AgentOrderController::class, 'view']);
    Route::get('order/{order}/{item}', [AgentOrderController::class, 'images']);
    Route::post('item/{item}', [OrderItemController::class, 'update_photo']);
});
