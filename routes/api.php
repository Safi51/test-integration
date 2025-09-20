<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\keyVerificationMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([KeyVerificationMiddleware::class])->group(function () {
    Route::get('hello', function () {
        return 'Hello World';
    });
});
