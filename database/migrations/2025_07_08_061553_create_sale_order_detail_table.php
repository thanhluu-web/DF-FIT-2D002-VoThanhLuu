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
        Schema::create('sale_order_detail', function (Blueprint $table) {
            $table->id();
            $table->string('sale_order_id');
            $table->foreign('sale_order_id')->references('sale_order_id')->on('sale_order');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product_data');
            $table->integer('qty_ordered');
            $table->integer('qty_delivered');
            $table->integer('qty_pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_detail');
    }
};
