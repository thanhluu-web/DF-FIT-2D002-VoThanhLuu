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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product_data');
            $table->string('sku');
            $table->string('name');
            $table->string('unit');
            $table->unsignedBigInteger('quantity');
            $table->string('status');
            $table->string('product_type');
            $table->date('received_at');
            $table->date('manufacture_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
