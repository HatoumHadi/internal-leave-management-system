<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeaveManagementController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $pendingLeaveRequests = LeaveRequest::with('user', 'leaveType')
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);


        $otherLeaveRequests = LeaveRequest::with('user', 'leaveType')
            ->whereIn('status', ['Approved', 'Rejected'])
            ->latest()
            ->paginate(10);

        $leaveRequests = LeaveRequest::with('user', 'leaveType')->latest()->paginate(10);

        return view('admin.leave-management', ['pendingLeaveRequests' => $pendingLeaveRequests, 'otherLeaveRequests' => $otherLeaveRequests, 'leaveRequests' => $leaveRequests]);
    }

    public function approve($id): RedirectResponse
    {
        $leaveRequest = LeaveRequest::find($id);
        $leaveRequest->status = 'approved';
        $leaveRequest->save();

        return redirect()->back()->with('success', 'The leave request has been approved successfully.');
    }


    public function reject(Request $request): RedirectResponse
    {
        $leaveRequest = LeaveRequest::find($request->id);
        $leaveRequest->status = 'rejected';
        $leaveRequest->save();

        return redirect()->back()->with('success', 'Leave request rejected successfully');
    }
}
