<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inbound_detail', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_id');
            $table->string('goods_receipt_no');
            $table->foreign('purchase_order_id')->references('purchase_order_id')->on('purchase_order');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product_data');
            $table->integer('quantity');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier');
            $table->string('status');         
            $table->integer('qty_received');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_detail');
    }
};
