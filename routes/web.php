<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Client\MasterController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\PickupController;

use App\Http\Controllers\Admin\AdminMasterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductManagmentController;
use App\Http\Controllers\Admin\SectorManagmentController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\TimeSlotController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

// Pickup Routes
Route::controller(PickupController::class)->group(function () {
    Route::get('/pickup/pack-menu', 'packMenu')->name('pickup-packmenupage');
    Route::get('/pickup/menu', 'showPackMenu')->name('pickup.menu');
    Route::get('/pickup/time-selection', 'showTimeSelection')->name('pickup.time_selection');
    Route::get('/pickup/timeslots', 'getTimeSlots')->name('pickup.time_slots');
    Route::post('/pickup/select-timeslot', 'selectTimeSlot')->name('pickup.select_timeslot');
});

Route::controller(ProductDetailController::class)->group(function () {
    Route::get('/product-details/{id}', 'get_ProductDetailsPage')->name('get-productdetailspage');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/start-order', 'start_order')->name('start-order');
    Route::get('/checkout', 'showCheckout')->name('checkout.show');
    Route::post('/checkout/process', 'processCheckout')->name('checkout.process');
    Route::get('/checkout/success/{order_id}', 'checkoutSuccess')->name('checkout.success');
    Route::get('/checkout/time-slots', 'getTimeSlots')->name('checkout.time_slots');
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
        Route::get('/', 'get_dashboard')->name('admin.dashboard');
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
        Route::get('', [OrderManagementController::class, 'index'])->name('admin.orders.index');
        Route::get('details/{order_id}', [OrderManagementController::class, 'show'])->name('admin.orders.show');
        Route::post('update-status/{order_id}', [OrderManagementController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::delete('delete/{order_id}', [OrderManagementController::class, 'destroy'])->name('admin.orders.destroy');
        Route::get('report', [OrderManagementController::class, 'generateReport'])->name('admin.orders.report');

        // Time Slot Management Routes
        Route::get('time-slots', [TimeSlotController::class, 'index'])->name('admin.time_slots.index');
        Route::post('time-slots/update', [TimeSlotController::class, 'update'])->name('admin.time_slots.update');
        Route::get('time-slots/preview', [TimeSlotController::class, 'preview'])->name('admin.time_slots.preview');
    });
});

// Cache clearing route
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache cleared successfully!";
});

// Diagnostic route
Route::get('/diagnostic', function() {
    try {
        // Check database connection
        $connection = DB::connection()->getPdo();
        $connection_status = "Connected successfully to database: " . DB::connection()->getDatabaseName();

        // Check tables
        $tables_exist = [
            'orders' => Schema::hasTable('orders'),
            'order_items' => Schema::hasTable('order_items'),
            'carts' => Schema::hasTable('carts'),
            'time_slots' => Schema::hasTable('time_slots'),
            'sectors' => Schema::hasTable('sectors')
        ];

        // Check Order model columns
        $order_columns = Schema::getColumnListing('orders');

        // Attempt to create a test model
        $test_order = new App\Models\Order();
        $fillable_fields = $test_order->getFillable();

        return response()->json([
            'connection' => $connection_status,
            'tables_exist' => $tables_exist,
            'order_columns' => $order_columns,
            'order_fillable_fields' => $fillable_fields,
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

