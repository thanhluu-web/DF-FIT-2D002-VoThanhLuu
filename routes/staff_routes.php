<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Staff\GoodReceiptController;
use App\Http\Controllers\Staff\PurchaseOrderController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    //Trang quản lý người dùng (không có quyền thêm hoặc xóa)
    Route::controller(UserController::class)->name('user.')->group(function(){
        Route::get('user-list','index')->name('list');
    });

    //Trang quản lý sản phẩm
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('list', 'index')->name('list');
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
    });

    //Nhà cung cấp
    Route::controller(SupplierController::class)->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
        Route::get('detail/{supplier}', 'detail')->name('detail');
    });

    // Quản lý PO
    Route::prefix('purchase-order')->name('purchase_order.')->controller(PurchaseOrderController::class)->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('detail/{purchase_order}', 'detail')->name('detail');
        Route::delete('cancel/{purchase_order}', 'cancel')->name('cancel');


    // Các route không nằm trong prefix purchase-order thì để riêng
        Route::get('/supplier-search', 'searchSupplier')->name('supplier.search');
        Route::get('/api/product-name', 'checkProductName')->name('checkProductName');
    });

    // Quản lý GR
    Route::prefix('goods-receipt')->name('goods_receipt.')->controller(GoodReceiptController::class)->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create/{PO}', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('detail', 'detail')->name('detail');
        Route::post('handle-receive', 'handleReceive')->name('handle_receive');
        Route::delete('cancel', 'cancel')->name('cancel');

        // Route kiểm tra PO không nằm trong nhóm theo yêu cầu
        Route::post('checkPO', 'checkPO')->name('check_PO');
        Route::get('inbound-detail', 'showInboundDetail')->name('inbound_detail');
    });
});

