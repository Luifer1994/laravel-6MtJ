<?php

use App\Http\Modules\DocumentTypes\Controllers\DocumentTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for DocumentTypes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(DocumentTypeController::class)->group(function () {
        Route::get('document-types-list', 'index')->middleware('permission:document-types-list');
    });
});

