<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_leave_request_creation()
    {
        // إنشاء مستخدم
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
        ]);

        // إرسال طلب إجازة
        $leaveRequest = LeaveRequest::create([
            'employee_id' => $user->id,
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
            'status' => 'pending'
        ]);

        // التحقق من أن طلب الإجازة تم تخزينه في قاعدة البيانات
        $this->assertDatabaseHas('leave_requests', [
            'employee_id' => $user->id,
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
            'status' => 'pending'
        ]);
    }
}
