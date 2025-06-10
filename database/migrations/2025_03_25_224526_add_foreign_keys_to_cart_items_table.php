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
        Schema::table('cart_items', function (Blueprint $table) {
            // العلاقة مع carts
            $table->foreign('cart_id')
                  ->references('cartId')
                  ->on('carts')
                  ->onDelete('cascade');

            // العلاقة مع products
            $table->foreign('product_id')
                  ->references('productId')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            //
        });
    }
};
