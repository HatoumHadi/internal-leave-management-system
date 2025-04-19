<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $leaveRequests = optional(auth()->user())->leaveRequests()->paginate(5);

        return view('user.dashboard', [
            'employee' => auth()->user(),
            'leaveRequests' => $leaveRequests,
        ]);
    }


    public function create()
    {
        $leaveTypes = LeaveType::all();

        return view('user.create-request', ['leaveTypes' => $leaveTypes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:255',
            'leave_type_id' => 'required|string|exists:leave_types,id',
        ], [
            'end_date.after_or_equal' => 'The "End Date" must be after or equal to the "Start Date".',
        ]);

        $employee = auth()->user();

        $overlappingLeave = $employee->leaveRequests()->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                });
        })->exists();

        if ($overlappingLeave) {
            return back()->with('error', 'Leave request overlaps with an existing leave request.');
        }

        $employee->leaveRequests()->create($request->only(['start_date', 'end_date', 'leave_type_id', 'reason']));

        return redirect()->route('dashboard')->with('success', 'Leave request submitted successfully.');
    }


    public function edit(string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveTypes = LeaveType::all();
        return view('user.edit-request', ['leaveRequest' => $leaveRequest, 'leaveTypes' => $leaveTypes]);
    }


    public function update(Request $request, string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:255',
            'leave_type_id' => 'required|int|exists:leave_types,id',
        ], [
            'end_date.after_or_equal' => 'The "End Date" must be after or equal to the "Start Date".',
        ]);
        $leaveRequest->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Your leave request has been updated successfully.');
    }


    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->delete();
        return redirect()->route('dashboard')->with('Success', 'Your leave request has been deleted successfully.');
    }

}
