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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->bigIncrements('feedback_id');
            $table->string('date');
            $table->text('images')->nullable();
            $table->text('description');
            $table->timestamps();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_item_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');;
            $table->foreign('order_item_id')->references('order_item_id')->on('order_items')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('feedback');
    }
};
