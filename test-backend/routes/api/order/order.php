<?php

use App\Http\Controllers\Order\OrderController;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Route;

Route::prefix('/order')->group(function(){

    Route::middleware([Authentication::class])->group(function(){
        Route::post('/create-order', [OrderController::class, 'createOrder']);
        Route::post('/create-order-item', [OrderController::class, 'createOrderItems']);
        Route::get('/get-all-order-item', [OrderController::class, 'getAllOrderitems']);
    });
});