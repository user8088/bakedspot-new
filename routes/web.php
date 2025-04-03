<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MasterController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\AdminMasterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductManagmentController;



Route::get('/', function () {
    return view('client.modules.home');
});

Route::controller(MasterController::class)->group(function () {
    Route::get('/', 'getHomePage')->name('get-homepage');
    Route::get('/pack-menu', 'get_PackMenuPage')->name('get-packmenupage');
    Route::get('/pack-menu/pack-4', 'get_PackFourPage')->name('get-packfourpage');
    Route::get('/pack-menu/pack-8', 'get_PackEightPage')->name('get-packeightpage');
});

Route::controller(ProductDetailController::class)->group(function () {
    Route::get('/product-details/{id}', 'get_ProductDetailsPage')->name('get-productdetailspage');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/start-order', 'start_order')->name('start-order');
});


Route::controller(AdminAuthController::class)->group(function () {
    Route::get('/panel', 'get_adminloginpage')->name('get-adminloginpage');
    Route::post('/login-admin','login_admin')->name('login-admin');
    Route::post('/logout-admin','logout_admin')->name('logout-admin');
});



// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::controller(AdminMasterController::class)->group(function () {
        Route::get('/dashboard', 'get_dashboard')->name('get-admindashboard');
    });

    Route::controller(ProductManagmentController::class)->group(function () {
        Route::get('/dashboard/product-managment', 'get_productmanagmentpage')->name('get-productmanagmentpage');
        Route::put('/dashboard/product-managment/edit-product/update-product/{id}', 'editProduct')->name('edit-product');
        Route::get('/dashboard/product-managment/edit-product/{id}', 'get_editpage')->name('get-editpage');
        Route::get('/dashboard/product-managment/new-product', 'get_newproductpage')->name('get-newproductpage');
        Route::post('/dashboard/product-managment/new-product/add-product', 'storeProduct')->name('store-product');
        Route::delete('/dashboard/product-managment/delete-product/{id}', 'deleteProduct')->name('delete-product');

    });
});
