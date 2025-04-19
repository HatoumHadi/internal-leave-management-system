<?php

namespace Tests\Feature\Admin;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
        $this->user = User::factory()->create();
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::find(1);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin.leave-management');
    }

    public function test_admin_can_approve_leave_request()
    {
        $admin = User::find(1);

        $leaveRequest = LeaveRequest::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/leave-approve/{$leaveRequest->id}");

        $response->assertRedirect();
        $this->assertEquals('approved', $leaveRequest->fresh()->status);
    }

    public function test_admin_can_reject_leave_request()
    {
        $admin = User::find(1);

        $leaveRequest = LeaveRequest::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/leave-reject/' . $leaveRequest->id);

        $response->assertRedirect();
        $this->assertEquals('rejected', $leaveRequest->fresh()->status);
    }
}
