<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_creation()
    {
        // إنشاء مستخدم
        $employee = User::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed.ali@example.com',
            'password' => bcrypt('ahmed123'),
        ]);

        // التحقق من أن الموظف موجود في قاعدة البيانات
        $this->assertDatabaseHas('users', [
            'email' => 'ahmed.ali@example.com',
        ]);
    }
}
