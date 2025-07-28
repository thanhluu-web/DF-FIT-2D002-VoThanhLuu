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
        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_id');
            $table->foreign('purchase_order_id')->references('purchase_order_id')->on('purchase_order');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product_data');
            $table->integer('qty_ordered');
            $table->integer('qty_received');
            $table->integer('qty_pending');
            $table->timestamps();
            $table->unique(['purchase_order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_detail');
    }
};
