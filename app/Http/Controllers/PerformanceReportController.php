<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\AttendanceReport;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PerformanceReportController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('performance_report.index', compact('employees'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employee,id',
            'report_type' => 'required|in:monthly,yearly',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'month' => 'required_if:report_type,monthly|integer|min:1|max:12',
        ]);

        $employeeId = $request->input('employee_id');
        $reportType = $request->input('report_type');
        $year = $request->input('year');
        $month = $request->input('month');

        $query = Attendance::query();

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($reportType === 'monthly') {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            $totalDays = 30; // Fixed to 30 days for monthly report
        } else {
            $startDate = Carbon::create($year, 1, 1)->startOfYear();
            $endDate = Carbon::create($year, 12, 31)->endOfYear();
            $totalDays = 365; // Fixed to 365 days for yearly report
        }

        $attendances = $query->whereBetween('created_at', [$startDate, $endDate])->get();

        // Update status based on scan time
        foreach ($attendances as $attendance) {
            $scanTime = Carbon::parse($attendance->created_at);
            if ($scanTime->hour >= 9) {
                $attendance->status = 'late';
            } else {
                $attendance->status = 'present';
            }
            $attendance->save();
        }

        // Calculate performance
        $presentCount = $attendances->where('status', 'present')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $performance = $totalDays > 0 ? (($presentCount + $lateCount) / $totalDays) * 100 : 0;

        // Create a new attendance report
        $report = AttendanceReport::create([
            'employee_id' => $employeeId,
            'report_type' => $reportType,
            'year' => $year,
            'month' => $month,
            'total_days' => $totalDays,
            'on_time_days' => $presentCount,
            'performance' => $performance,
        ]);

        return view('performance_report.report', compact('attendances', 'performance', 'reportType', 'year', 'month', 'employeeId', 'report', 'presentCount', 'absentCount', 'lateCount', 'totalDays'));
    }

    public function downloadPDF(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employee,id',
            'report_type' => 'required|in:monthly,yearly',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'month' => 'required_if:report_type,monthly|integer|min:1|max:12',
        ]);

        $employeeId = $request->input('employee_id');
        $reportType = $request->input('report_type');
        $year = $request->input('year');
        $month = $request->input('month');

        $query = Attendance::query();

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($reportType === 'monthly') {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            $totalDays = 30; // Fixed to 30 days for monthly report
        } else {
            $startDate = Carbon::create($year, 1, 1)->startOfYear();
            $endDate = Carbon::create($year, 12, 31)->endOfYear();
            $totalDays = 365; // Fixed to 365 days for yearly report
        }

        $attendances = $query->whereBetween('created_at', [$startDate, $endDate])->get();

        // Update status based on scan time
        foreach ($attendances as $attendance) {
            $scanTime = Carbon::parse($attendance->created_at);
            if ($scanTime->hour >= 9) {
                $attendance->status = 'late';
            } else {
                $attendance->status = 'present';
            }
            $attendance->save();
        }

        // Calculate performance
        $presentCount = $attendances->where('status', 'present')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $performance = $totalDays > 0 ? (($presentCount + $lateCount) / $totalDays) * 100 : 0;

        // Create a new attendance report
        $report = AttendanceReport::create([
            'employee_id' => $employeeId,
            'report_type' => $reportType,
            'year' => $year,
            'month' => $month,
            'total_days' => $totalDays,
            'on_time_days' => $presentCount,
            'performance' => $performance,
        ]);

        $pdf = Pdf::loadView('performance_report.pdf', compact('attendances', 'performance', 'reportType', 'year', 'month', 'employeeId', 'report', 'presentCount', 'absentCount', 'lateCount', 'totalDays'));

        return $pdf->download('performance_report.pdf');
    }
}