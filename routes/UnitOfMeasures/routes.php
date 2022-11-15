<?php

use App\Http\Modules\UnitOfMeasures\Controllers\UnitOfMeasureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Unit of Measures
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(UnitOfMeasureController::class)->group(function () {
        Route::get('unit-of-measures-list', 'index')->middleware('permission:units-of-measures-list');
    });
});
