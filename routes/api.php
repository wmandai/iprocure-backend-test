<?php

use App\Http\Controllers\Api\v1\AuthApiController;
use App\Http\Controllers\Api\v1\ProductsApiController;
use App\Http\Controllers\Api\v1\ProfileApiController;
use App\Http\Controllers\Api\v1\RolesApiController;
use App\Http\Controllers\Api\v1\UsersApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'as' => 'api.'
], function () {
    // Authentication endpoints
    Route::post('auth/login', [AuthApiController::class, 'login']);
    Route::post('auth/register', [AuthApiController::class, 'register']);
    Route::post('auth/logout', [AuthApiController::class, 'logout']);
    Route::post('auth/refresh', [AuthApiController::class, 'refresh']);

    Route::group(['middleware' => ['auth:api']], function () {
        // get logged in user profile
        Route::get('profile', [ProfileApiController::class, 'profile']);
        // Manage roles endpoints
        Route::post('roles/new', [RolesApiController::class, 'create']);
        Route::get('roles/show', [RolesApiController::class, 'index']);
        Route::get('roles/view/{id}', [RolesApiController::class, 'view']);
        Route::put('roles/update/{id}', [RolesApiController::class, 'update']);
        Route::delete('roles/delete/{id}', [RolesApiController::class, 'destroy']);
        // manage users endpoints
        Route::post('users/new', [UsersApiController::class, 'create']);
        Route::get('users/show', [UsersApiController::class, 'index']);
        Route::get('users/view/{id}', [UsersApiController::class, 'view']);
        Route::put('users/update/{id}', [UsersApiController::class, 'update']);
        Route::delete('users/delete/{id}', [UsersApiController::class, 'destroy']);
        // manage products endpoints
        Route::post('products/new', [ProductsApiController::class, 'create']);
        Route::get('products/show', [ProductsApiController::class, 'index']);
        Route::get('products/view/{id}', [ProductsApiController::class, 'view']);
        Route::get('products/mine', [ProductsApiController::class, 'mine']);
        Route::post('products/search', [ProductsApiController::class, 'search']);
        Route::put('products/update/{id}', [ProductsApiController::class, 'update']);
        Route::delete('products/delete/{id}', [ProductsApiController::class, 'destroy']);
    });
});
