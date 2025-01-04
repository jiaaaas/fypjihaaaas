<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('employee')
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->paginate(10);        
            
        return view('leave.index', compact('leaves'));
    }


    public function updateStatus(Request $request, $id)
{
    $leave = Leave::findOrFail($id);
    $leave->status = $request->status;
    $leave->save();

    if ($request->status == 'approved') {
        $employee = $leave->employee;
        $today = now()->toDateString();

        Attendance::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'created_at' => $today,
            ],
            [
                'status' => 'absent',
            ]
        );
    }elseif ($request->status == 'rejected') {
        // Ensure attendance is not marked as absent, allowing it to be flagged as late
        $employee = $leave->employee;
        $today = now()->toDateString();

        Attendance::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'created_at' => $today,
            ],
            [
                'status' => null, // No explicit status, to handle late attendance logic
            ]
        );
    }

    return redirect()->route('leave.index')->with('success', 'Leave status updated successfully.');
}

// public function updateStatus(Request $request, $id)
// {
//     $leave = Leave::find($id);
//     $leave->status = $request->input('status');
//     $leave->save();

//     // Update attendance if necessary, or add logic to ensure the employee is marked absent on leave days
//     if ($leave->status == 'approved') {
//         // Logic to mark the employee as absent on leave days from start_date to end_date
//         Attendance::where('employee_id', $leave->employee_id)
//                   ->whereBetween('created_at', [$leave->start_date, $leave->end_date])
//                   ->update(['status' => 'absent']);
//     }

//     return redirect()->route('leave.index')->with('success', 'Leave status updated successfully.');
// }


}
