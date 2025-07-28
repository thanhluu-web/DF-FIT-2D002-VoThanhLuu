<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(AdminMiddleware::class)->group(function () {

    Route::controller(UserController::class)->name('user.')->group(function(){
        Route::get('user-list','index')->name('list');
        Route::get('user-create','create')->name('create');
        Route::post('user-store','store')->name('store');
        Route::get('user-detail/{user}','edit')->name('detail');
        Route::put('user-update/{user}','update')->name('update');
        Route::delete('user-delete/{user}','destroy')->name('delete');
    });

    //Trang quản lý sản phẩm
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('detail/{product}', 'detail')->name('detail');
        Route::put('detail/{product}', 'update')->name('update');
        Route::delete('delete/{product}', 'destroy')->name('delete');
    });

    //Tồn kho
    Route::controller(InventoryController::class)->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('list', 'index')->name('list');
        Route::put('update', 'update')->name('updateStatus');
    });

    //Khách hàng
    Route::controller(CustomerController::class)->prefix('customer')->name('customer.')->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
        Route::get('detail/{customer}', 'detail')->name('detail');
        Route::put('detail/{customer}', 'update')->name('update');
        Route::delete('delete/{customer}', 'destroy')->name('delete');
    });

    //Nhà cung cấp
    Route::controller(SupplierController::class)->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
        Route::get('detail/{supplier}', 'detail')->name('detail');
        Route::put('detail/{supplier}', 'update')->name('update');
        Route::delete('delete/{supplier}', 'destroy')->name('delete');
    });
});