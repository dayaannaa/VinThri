<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('order_item_id');
            $table->string('quantity');
            $table->timestamps();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');;
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('order_items');
    }
};
