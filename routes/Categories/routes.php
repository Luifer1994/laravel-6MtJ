<?php

use App\Http\Modules\Categories\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Categories
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::post('categories-create', 'store')->middleware('permission:categories-create');
        Route::get('categories-list', 'index')->middleware('permission:categories-list');
        Route::get('categories-show/{id}', 'show')->middleware('permission:categories-show');
        Route::put('categories-update/{id}', 'update')->middleware('permission:categories-update');
        Route::delete('categories-destroy/{id}', 'destroy')->middleware('permission:categories-destroy');
    });
});
