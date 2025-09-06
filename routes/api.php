<?php

use Illuminate\Support\Facades\Route;


Route::get('/health', fn() => response()->json(['status' => 'ok'], 200));
Route::get('/ready', fn() => response()->json(['status' => 'ready'], 200));
