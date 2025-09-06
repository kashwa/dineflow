<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;


Route::get('/health', fn() => response()->json(['status' => 'ok'], 200));
Route::get('/ready', fn() => response()->json(['status' => 'ready'], 200));



Route::middleware(['tenant'])->group(function () {
    // Public auth
    Route::post('/v1/auth/register', [AuthController::class, 'register']);
    Route::post('/v1/auth/login',    [AuthController::class, 'login']);

    // Protected
    Route::middleware(['auth:sanctum','throttle:tenant-api'])->group(function () {
        Route::get('/v1/auth/me', [AuthController::class, 'me']);
        Route::post('/v1/auth/logout', [AuthController::class, 'logout']);

        // Example protected resource (placeholder)
        Route::get('/v1/menus', [MenuController::class, 'index']) // ->can('viewAny', Menu::class)
              ->middleware('abilities:basic'); // optional Sanctum ability gate
    });
});

