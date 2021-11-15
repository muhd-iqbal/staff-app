<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('profile', [UserController::class, 'show']);
Route::patch('profile/update/{user}', [UserController::class, 'update']);
Route::get('profile/upload', [PhotoController::class, 'create']);
Route::patch('profile/upload/{user}', [PhotoController::class, 'update']);

Route::get('staff', [UserController::class, 'list']);

require __DIR__.'/auth.php';
