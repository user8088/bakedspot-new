<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MasterController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\CartController;

use App\Http\Controllers\Admin\AdminMasterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductManagmentController;
use App\Http\Controllers\Admin\SectorManagmentController;
use App\Http\Controllers\Admin\OrderManagementController;




Route::get('/', function () {
    return view('client.modules.home');
});

Route::controller(MasterController::class)->group(function () {
    Route::get('/', 'getHomePage')->name('get-homepage');
    Route::get('/pack-menu', 'get_PackMenuPage')->name('get-packmenupage');
    Route::get('/pack-menu/pack-4', 'get_PackFourPage')->name('get-packfourpage');
    Route::get('/pack-menu/pack-8', 'get_PackEightPage')->name('get-packeightpage');
    Route::post('/save-sector', 'saveSectorSelection')->name('save.sector');
});

Route::controller(ProductDetailController::class)->group(function () {
    Route::get('/product-details/{id}', 'get_ProductDetailsPage')->name('get-productdetailspage');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/start-order', 'start_order')->name('start-order');
    Route::get('/checkout', 'showCheckout')->name('checkout.show');
    Route::post('/checkout/process', 'processCheckout')->name('checkout.process');
    Route::get('/checkout/success/{order_id}', 'checkoutSuccess')->name('checkout.success');
});


Route::controller(AdminAuthController::class)->group(function () {
    Route::get('/panel', 'get_adminloginpage')->name('get-adminloginpage');
    Route::post('/login-admin','login_admin')->name('login-admin');
    Route::post('/logout-admin','logout_admin')->name('logout-admin');
});

// Cart Routes
Route::middleware(['web'])->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::post('/cart/add','add')->name('cart.add');
        Route::get('/cart', 'showCart')->name('cart.show');  // Add this route to display the cart
        Route::post('/cart/remove', 'remove')->name('cart.remove');
    });
});



// Protected Routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::controller(AdminMasterController::class)->group(function () {
        Route::get('/', 'get_dashboard')->name('get-admindashboard');
    });

    Route::controller(ProductManagmentController::class)->group(function () {
        Route::get('/product-managment', 'get_productmanagmentpage')->name('get-productmanagmentpage');
        Route::put('/product-managment/edit-product/update-product/{id}', 'editProduct')->name('edit-product');
        Route::get('/product-managment/edit-product/{id}', 'get_editpage')->name('get-editpage');
        Route::get('/product-managment/new-product', 'get_newproductpage')->name('get-newproductpage');
        Route::post('/product-managment/new-product/add-product', 'storeProduct')->name('store-product');
        Route::delete('/product-managment/delete-product/{id}', 'deleteProduct')->name('delete-product');
    });

    Route::prefix('sector-managment')->group(function () {
        Route::controller(SectorManagmentController::class)->group(function () {
            Route::get('/','get_sectorManagmentPage')->name('get-sectormanagmentpage');
                Route::prefix('add-sector')->group(function () {
                    Route::get('/','get_addnewsectorpage')->name('get-addnewsectorpage');
                    Route::post('/add-new','addNewSector')->name('add-newsector');
                    Route::put('/update-sector/{id}','updateSector')->name('update-sector');
                    Route::delete('/delete-sector/{id}','deleteSector')->name('delete-sector');
            });
        });
    });

    // Order Management Routes
    Route::prefix('orders')->group(function () {
        Route::get('', [OrderManagementController::class, 'get_ordersManagementPage'])->name('admin.orders.index');
        Route::get('details/{order_id}', [OrderManagementController::class, 'get_orderDetails'])->name('admin.orders.show');
        Route::post('update-status/{order_id}', [OrderManagementController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
        Route::delete('delete/{order_id}', [OrderManagementController::class, 'deleteOrder'])->name('admin.orders.delete');
        Route::get('report', [OrderManagementController::class, 'getOrdersReport'])->name('admin.orders.report');
    });
});

