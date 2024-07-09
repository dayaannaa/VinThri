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
    Schema::create('carts', function (Blueprint $table) {
        $table->bigIncrements('cart_id');
        $table->string('quantity');
        $table->timestamps();
        $table->unsignedBigInteger('customer_id');
        $table->unsignedBigInteger('product_id');

        // Foreign key constraints with cascade delete
        $table->foreign('customer_id')
              ->references('customer_id')
              ->on('customers')
              ->onDelete('cascade'); // Cascade delete for customers

        $table->foreign('product_id')
              ->references('product_id')
              ->on('products')
              ->onDelete('cascade'); // Cascade delete for products
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('carts');
    }
};
