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
        Schema::create('merchant_documents', function (Blueprint $table) {
            $table->id('documentId');
            $table->unsignedBigInteger('MerchantId');
            $table->string('documentType');
            $table->string('documentImage');
            $table->date('uploadDate');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_documents');
    }
};
