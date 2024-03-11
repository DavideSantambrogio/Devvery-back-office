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
        Schema::create('food_order', function (Blueprint $table) {
            $table->unsignedBigInteger('food_id');
            $table->foreign('food_id')->references('id')->on('foods')->cascadeOnDelete();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();

            $table->unsignedTinyInteger('quantity_ordered')->default(1);

            $table->primary(['food_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_order');
    }
};
