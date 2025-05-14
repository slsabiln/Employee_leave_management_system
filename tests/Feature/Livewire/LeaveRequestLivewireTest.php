<?php

namespace Tests\Feature\Livewire;
namespace App\Http\Livewire;
use App\Models\LeaveRequest;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class LeaveRequestLivewireTest extends TestCase
{
    public function test_leave_request_component_can_render()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\LeaveRequestComponent::class)
            ->assertStatus(200)
            ->assertSee('Leave Requests');
    }

    public function test_leave_request_creation()
    {
        $user = User::factory()->create();

        $response = Livewire::actingAs($user)
            ->test(\App\Http\Livewire\LeaveRequestComponent::class)
            ->set('start_date', '2025-06-01')
            ->set('end_date', '2025-06-10')
            ->call('submitRequest');

        // التحقق من أن الطلب تم تخزينه
        $this->assertDatabaseHas('leave_requests', [
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
        ]);
    }
}
