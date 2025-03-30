<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MasterController;


Route::get('/', function () {
    return view('client.modules.home');
});

Route::controller(MasterController::class)->group(function () {
    Route::get('/product-details', 'get_ProductDetailsPage')->name('get-productdetailspage');
});
