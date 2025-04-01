<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MasterController;


Route::get('/', function () {
    return view('client.modules.home');
});

Route::controller(MasterController::class)->group(function () {
    Route::get('/product-details', 'get_ProductDetailsPage')->name('get-productdetailspage');
    Route::get('/pack-menu', 'get_PackMenuPage')->name('get-packmenupage');
    Route::get('/pack-menu/pack-4', 'get_PackFourPage')->name('get-packfourpage');
    Route::get('/pack-menu/pack-8', 'get_PackEightPage')->name('get-packeightpage');



});
