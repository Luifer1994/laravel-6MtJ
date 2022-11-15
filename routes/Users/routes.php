<?php

use App\Http\Modules\Users\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Users
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('logout', 'logout');
        Route::post('users-create', 'store')->middleware('permission:users-create');
        Route::get('users-list', 'index')->middleware('permission:users-list');
        Route::get('users-show/{id}', 'show')->middleware('permission:users-show');
        Route::put('users-update/{id}', 'update')->middleware('permission:users-update');
        Route::delete('users-destroy/{id}', 'destroy')->middleware('permission:users-destroy');
        Route::post('users-assign-role', 'asingRole')->middleware('permission:users-assign-role');
        Route::get('users-validate-session','validateAuth');
    });
});
