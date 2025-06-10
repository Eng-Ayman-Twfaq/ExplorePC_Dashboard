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
        Schema::table('reviews', function (Blueprint $table) {
            // العلاقة مع products
            if (!Schema::hasColumn('reviews', 'productId')) {
                $table->foreign('productId')
                      ->references('productId')
                      ->on('products')
                      ->onDelete('cascade');
            }
    
            // العلاقة مع customs
            if (!Schema::hasColumn('reviews', 'UserId')) {
                $table->foreign('UserId')
                      ->references('UserId')
                      ->on('customs')
                      ->onDelete('cascade');
            }
        });
    }
    
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['productId']);
            $table->dropForeign(['UserId']);
        });
    }
};
