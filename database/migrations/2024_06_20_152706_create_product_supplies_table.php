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
        Schema::create('product_supplies', function (Blueprint $table) {
            $table->bigIncrements('product_supplier_id');
            $table->date('date_supplied');
            $table->string('price');
            $table->timestamps();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');;
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');;
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('product_supplies');
    }
};
