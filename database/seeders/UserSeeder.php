<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء موظف
        User::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed.ali@example.com',
            'password' => bcrypt('ahmed123'),
            'is_admin' => false, // موظف
        ]);

        // إنشاء أدمن
        User::create([
            'name' => 'Slsabil Nabil',
            'email' => 'Slsabil.nabil5673@gmail.com',
            'password' => bcrypt('slsabil123'),
            'is_admin' => true, // أدمن
        ]);
    }
}
