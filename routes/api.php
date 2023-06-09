<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
});
Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::post('store', 'store');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'delete');
    });
});
