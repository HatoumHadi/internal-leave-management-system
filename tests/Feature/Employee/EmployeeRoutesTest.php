<?php

namespace Tests\Feature\Employee;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class EmployeeRoutesTest extends TestCase
{
    use RefreshDatabase;

    public $employee;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');

        $this->employee = User::factory()->create();
    }

    public function test_employee_can_view_dashboard()
    {
        $leaveRequest = LeaveRequest::factory()->create(['user_id' => $this->employee->id]);

        $response = $this->actingAs($this->employee)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('user.dashboard');
        $response->assertSee($leaveRequest->reason);
    }

    public function test_employee_can_create_leave_request()
    {
        $leaveType = LeaveType::factory()->create(['name' => 'Sick Leave']);

        $this->employee->email_verified_at = now();
        $this->employee->save();

        $response = $this->actingAs($this->employee)->get('/leave-request/create');

        $response->assertStatus(200);

        $response->assertViewIs('user.create-request');

        $response->assertSee($leaveType->name);
    }





    public function test_employee_can_store_leave_request()
    {
        $leaveRequestData = [
            'leave_type_id' => (string) LeaveType::factory()->create()->id,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'reason' => 'Personal Leave',
        ];

        $response = $this->actingAs($this->employee)->post('/leave-request', $leaveRequestData);

        $response->assertRedirect(route('dashboard'));

        $response->assertSessionHas('success', 'Leave request submitted successfully.');

        $this->assertDatabaseHas('leave_requests', [
            'user_id' => $this->employee->id,
            'leave_type_id' => $leaveRequestData['leave_type_id'],
        ]);
    }






    public function test_employee_can_edit_leave_request()
    {
        $leaveRequest = LeaveRequest::factory()->create(['user_id' => $this->employee->id]);

        $this->employee->email_verified_at = now();
        $this->employee->save();

        $response = $this->actingAs($this->employee)->get('/leave-request/' . $leaveRequest->id . '/edit');

        $response->assertStatus(200);

        $response->assertViewIs('user.edit-request');

        $response->assertSee($leaveRequest->reason);
    }


    public function test_employee_can_update_leave_request()
    {
        $leaveRequest = LeaveRequest::factory()->create(['user_id' => $this->employee->id]);

        $this->employee->email_verified_at = now();
        $this->employee->save();

        $updatedData = [
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(3),
            'reason' => 'Updated reason',
            'leave_type_id' => LeaveType::first()->id,
        ];

        $response = $this->actingAs($this->employee)->put('/leave-request/' . $leaveRequest->id, $updatedData);

        $response->assertRedirect('/dashboard');

        $response->assertSessionHas('success', 'Your leave request has been updated successfully.');

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leaveRequest->id,
            'start_date' => $updatedData['start_date'],
            'end_date' => $updatedData['end_date'],
            'reason' => $updatedData['reason'],
        ]);
    }


    public function test_employee_can_delete_leave_request()
    {
        $leaveRequest = LeaveRequest::factory()->create(['user_id' => $this->employee->id]);

        $this->employee->email_verified_at = now();
        $this->employee->save();

        $response = $this->actingAs($this->employee)->delete('/leave-request/' . $leaveRequest->id);

        $response->assertRedirect('/dashboard');

        $response->assertSessionHas('Success', 'Your leave request has been deleted successfully.');

        $this->assertDatabaseMissing('leave_requests', [
            'id' => $leaveRequest->id,
        ]);
    }
}
