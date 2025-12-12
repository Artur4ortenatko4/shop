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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'processed', 'shipped', 'delivered']);
            $table->text('name');
            $table->text('email');
            $table->text('phone');
            $table->text('surname');
            $table->text('settlement');
            $table->timestamps();

            // $table->foreign('cart_id')->references('id')->on('carts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
