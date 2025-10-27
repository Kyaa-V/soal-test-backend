<?php

use App\Http\Controllers\Vendor\VendorController;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Log::info('route vendor');
Route::prefix('/vendor')->group(function(){
    Route::middleware([Authentication::class])->group(function(){
        Log::info('route vendor middleware auth passed');
        Route::post('/create-vendor', [VendorController::class, 'createVendor']);
    
        // Route::middleware([Authentication::class])->group(function () {
            Route::get('/get-all-vendors', [VendorController::class, 'getAllVendors']);
        // });
    });

}); 