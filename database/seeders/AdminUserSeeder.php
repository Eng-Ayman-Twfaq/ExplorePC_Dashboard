<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        \App\Models\User::create([
            'UserName' => 'Admin',
            'UserPassword' => bcrypt('admin123'), // كلمة مرور مشفرة
            'Phone' => 0123456789,
            'Address' => 'Admin Headquarters',
        ]);
    }
}
