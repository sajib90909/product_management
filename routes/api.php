<?php

use App\Http\Controllers\API\Authenticate\AuthController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\API\Product\ProductImageController;
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

Route::post('user/registration', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product:slug}', [ProductController::class, 'get']);
});

Route::group(['prefix' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('user/logout', [AuthController::class, 'logout']);
    Route::get('user/auth-user', [AuthController::class, 'authUser']);

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('add', [CategoryController::class, 'create']);
        Route::post('update/{category}', [CategoryController::class, 'update']);
        Route::post('delete/{category}', [CategoryController::class, 'delete']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::post('add', [ProductController::class, 'create']);
        Route::post('update/{product:slug}', [ProductController::class, 'update']);
        Route::delete('delete/{product}', [ProductController::class, 'delete']);
        Route::delete('image/delete/{id}', [ProductImageController::class, 'delete']);
    });
});