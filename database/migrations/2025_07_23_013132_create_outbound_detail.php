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
        Schema::create('outbound_detail', function (Blueprint $table) {
            $table->id();
            $table->string('sale_order_id');
            $table->foreign('sale_order_id')->references('sale_order_id')->on('sale_order');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product_data');
            $table->integer('quantity');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer');
            $table->string('status');         
            $table->integer('qty_issued');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbound_detail');
    }
};
