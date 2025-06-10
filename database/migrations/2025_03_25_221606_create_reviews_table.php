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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('reviewId');
            $table->unsignedBigInteger('productId');
            $table->unsignedBigInteger('UserId');
            $table->float('rating');
            $table->text('comment')->nullable();
            $table->dateTime('date');
            $table->timestamps();

            $table->foreign('productId')->references('productId')->on('products')->onDelete('cascade');
            $table->foreign('UserId')->references('UserId')->on('customs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
