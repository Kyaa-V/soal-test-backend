<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/health', function(){
    return response()->json([
        'message' => ' api is healthly',
    ],200);
});

Route::prefix('/v1')->group(function () {
    require __DIR__ . '/api/auth/auth.php';
    require __DIR__ . '/api/vendor/vendor.php';
    require __DIR__ . '/api/order/order.php';
    require __DIR__ . '/api/item/item.php';
});