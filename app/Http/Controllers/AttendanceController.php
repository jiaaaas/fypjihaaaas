<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Get all employees who are not on leave between today's date and the end of the day
        $employeesNotOnLeave = Employee::whereNotIn('id', function($query) {
            $query->select('employee_id')
                ->from('leaves')
                ->where('status', 'approved')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now());
        })
        ->get();

        // Get all employees who have not scanned attendance today
        $employeesNotScanned = $employeesNotOnLeave->whereNotIn('id', Attendance::whereDate('created_at', today())->pluck('employee_id'));

        return view('attendance.index', compact('employeesNotScanned'));
    }


    



    public function update(Request $request)
    {
        $employeeIds = $request->input('employee_ids', []);
        $today = Carbon::today();

        foreach ($employeeIds as $employeeId) {
            Attendance::updateOrCreate(
                [
                    'employee_id' => $employeeId,
                    'created_at' => $today,
                ],
                [
                    'scanned' => true,
                    'status' => 'present', // Assuming this marks them as scanned
                ]
            );
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }





    public function downloadExcel()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }

    public function downloadPDF()
    {
        $attendanceRecords = Attendance::with('employee')->get(); // Get your data
        $pdf = Pdf::loadView('pdf.attendance', compact('attendanceRecords')); // Correct variable name in compact()
        return $pdf->download('attendance.pdf');
    }
    
}
