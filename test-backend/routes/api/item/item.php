<?php

use App\Http\Controllers\Item\ItemController;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Route;


Route::prefix('/item')->group(function(){
    Route::middleware([Authentication::class])->group(function(){
        Route::get('/get-all-item', [ItemController::class, 'getAllItems']);
        Route::get('/get-item', [ItemController::class, 'getOrderItem']);
    });
});