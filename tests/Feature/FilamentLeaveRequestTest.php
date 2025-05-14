<?php

namespace Tests\Feature;

use App\Models\LeaveRequest;
use App\Models\User;
use Filament\Tables\Actions\ButtonAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_leave_request_via_filament()
    {
        // تسجيل الدخول كمدير
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true
        ]);

        // إنشاء طلب إجازة من خلال Filament
        $this->actingAs($admin)->post(route('filament.resources.leave-requests.create'), [
            'employee_id' => 1,
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
            'status' => 'pending',
        ]);

        // التأكد من أن طلب الإجازة تم تخزينه في قاعدة البيانات
        $this->assertDatabaseHas('leave_requests', [
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
            'status' => 'pending',
        ]);
    }

    public function test_can_approve_leave_request_via_filament()
    {
        // إنشاء طلب إجازة
        $leaveRequest = LeaveRequest::create([
            'employee_id' => 1,
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
            'status' => 'pending'
        ]);

        // تسجيل الدخول كمدير
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true
        ]);

        // محاكاة الضغط على زر الموافقة
        $this->actingAs($admin)->post(route('filament.resources.leave-requests.approve', $leaveRequest));

        // التأكد من أن حالة الطلب تم تغييرها إلى "approved"
        $leaveRequest->refresh();
        $this->assertEquals('approved', $leaveRequest->status);
    }
}
