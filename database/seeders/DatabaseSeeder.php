<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مستخدم Admin افتراضي
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // التشفير التلقائي بـ Bcrypt
        ]);

        // (اختياري) إنشاء مستخدمين إضافيين للاختبار
        User::factory(10)->create();
    }
}
