<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::prefix('shops')->controller(ShopController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('{shop}', 'show');
    Route::get('{shop}/products/{product}/sell', 'sell');
    Route::delete('{shop}', 'destroy');
});
