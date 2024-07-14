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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->string('address');
            // $table->string('status');
            $table->string('email')->unique();
            // $table->string('password');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('cascade');

      $table->index('user_id');

      $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('customers');
    }
};
