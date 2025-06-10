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
    Schema::table('customs', function (Blueprint $table) {
        if (!Schema::hasColumn('customs', 'email')) {
            $table->string('email')->unique()->after('UserName');
        }
    });
}

public function down(): void
{
    Schema::table('customs', function (Blueprint $table) {
        $table->dropColumn('email');
    });
}
};
