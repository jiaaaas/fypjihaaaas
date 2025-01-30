<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\StatusWork;
use Illuminate\Http\Request;
use App\Mail\LateScanNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['department', 'statusWork']) // eager load relationships
        ->filter(request()->only(['name', 'position', 'phone_no', 'email', 'address', 'status_work_id']))
        ->paginate(10);

    return view('employee.index', compact('employees'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $employees = Employee::inRandomOrder()->first();
        $statusWorks = StatusWork::all();
        $departments = Department::all();


        return view('employee.create', compact('statusWorks', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status_work_id' => 'required',
            'department_id' => 'required',
            'password' => 'required|string|min:8',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        // Create the employee record
        $employee = Employee::create($validated);
    
        // Create the user record and link the employee_id to the employee's ID
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Ensure password is hashed
            'employee_id' => $employee->id, // Set the employee_id from the created employee
        ]);
    
        return to_route('employee.index')->withSuccess(__('Employee').' '.__('Successfully').' '.__('Added'));
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employees = Employee::with(['statusWork', 'department'])->findOrFail($id);

        return view('employee.show', compact('employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employees = Employee::findOrFail($id); 
        $departments = Department::all(); 
        $statusWorks = StatusWork::all(); 
    
        return view('employee.edit', compact('employees', 'departments', 'statusWorks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
     
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status_work_id' => 'required',
            'department_id' => 'required',
            'password' => 'nullable|string|min:8',
        ]);
    
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        $employee->update($validated);
    
        // Update the user linked to the employee
        $user = User::where('employee_id', $employee->id)->first();
        if ($user) {
            $user->update([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => $employee->password ?? $user->password,
            ]);
        }
    
        return redirect(route('employee.index'))->withSuccess(__('Employee').' '.__('Successfully').' '.__('Updated'));
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    
        // Remove the user linked to the employee
        User::where('employee_id', $employee->id)->delete();
    
        return redirect(route('employee.index'))->withSuccess(__('Employee').' '.__('Successfully').' '.__('Deleted')); 
    }
    


    public function dashboard(Request $request)
    {
         //Calculate total employees
        $totalEmployees = Employee::count();
    
        // Define "start time" threshold for late check (e.g., 9:00 AM)
        $startTime = now()->startOfDay()->addHours(9);
    
        // Employees who scanned the QR code today (excluding absent)
        $employeesScanned = Attendance::whereDate('created_at', now()->toDateString())
            ->where('status', '!=', 'absent') // Exclude absent employees
            ->with('employee')
            ->get();
    
        // Get the IDs of employees who scanned the QR code
        $scannedEmployeeIds = $employeesScanned->pluck('employee_id')->toArray();
    
        // Find all employees who are not in the scanned list (not scanned)
        $employeesNotScanned = Employee::whereNotIn('id', $scannedEmployeeIds)->get();
    
        // Calculate totalLateToday (employees who scanned after 9 AM or not scanned at all)
        $totalLateToday = $employeesScanned->filter(function ($attendance) use ($startTime) {
            return $attendance->created_at > $startTime;
        })->count();
    
        // Add the number of employees who haven't scanned as late
        $totalLateToday += $employeesNotScanned->count();
    
        // Get approved leave for today (marking employees as absent)
        $approvedLeaves = Leave::where('status', 'approved')
            ->whereDate('start_date', now()->toDateString())
            ->pluck('employee_id')
            ->toArray();
    
        // Subtract the number of approved leaves from the late count (those on leave are not late)
        $totalLateToday -= count($approvedLeaves);
    
        // Get total absent employees based on approved leave
        $totalAbsentToday = Leave::where('status', 'approved')
                                ->whereDate('start_date', '<=', today())
                                ->whereDate('end_date', '>=', today())
                                ->count();

        // Send email to employees who haven't scanned by 9 AM
        foreach ($employeesNotScanned as $employee) {
            if (!in_array($employee->id, $approvedLeaves)) {
                Mail::to($employee->email)->send(new LateScanNotification($employee));
            }
        }

        // Calculate performance for the month
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        // Get all attendance records for the month
        $attendanceThisMonth = Attendance::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->with('employee')
            ->get();
    
        // Calculate performance for each employee
        $employeePerformance = [];
        foreach ($attendanceThisMonth->groupBy('employee_id') as $employeeId => $attendances) {
            $employee = Employee::find($employeeId);
            $totalDaysAttended = $attendances->count();
            $onTimeAttendance = $attendances->filter(function ($attendance) use ($startTime) {
                return $attendance->created_at <= $startTime;
            })->count();
    
            // Calculate performance as the percentage of on-time attendance
            $performance = ($totalDaysAttended > 0) ? ($onTimeAttendance / $totalDaysAttended) * 100 : 0;
    
            $employeePerformance[] = [
                'employee' => $employee,
                'performance' => $performance,
                'total_days' => $totalDaysAttended,
                'on_time' => $onTimeAttendance
            ];
        }
    
        // Calculate average performance for the month (based on all employees)
            $totalPerformance = collect($employeePerformance)->sum('performance');
            $averagePerformance = $employeePerformance ? $totalPerformance / count($employeePerformance) : 0;
        
        // Get the start and end of the current week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Fetch attendance data for the current week
        $attendanceThisWeek = Attendance::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with('employee')
            ->get();

        // Prepare data for the attendance chart
        $attendanceLabels = collect();
        $attendanceData = collect();

        for ($date = $startOfWeek; $date <= $endOfWeek; $date->addDay()) {
            $attendanceLabels->push($date->format('d M'));
            $attendanceData->push(
                $attendanceThisWeek->where('created_at', '>=', $date->startOfDay())
                    ->where('created_at', '<=', $date->endOfDay())
                    ->count()
            );
        }

        // // Prepare data for the attendance chart
        // $attendanceLabels = $attendanceThisMonth->groupBy(function ($attendance) {
        //     return $attendance->created_at->format('d M');
        // })->keys();

        // $attendanceData = $attendanceThisMonth->groupBy(function ($attendance) {
        //     return $attendance->created_at->format('d M');
        // })->map->count();   

        // Return data to the view
        return view('dashboard', compact(
            'totalEmployees',
            'employeesScanned',
            'totalLateToday',
            'totalAbsentToday',
            'averagePerformance',
            'startTime',
            // 'startOfWeek',
            // 'endOfWeek',
            'attendanceLabels',
            'attendanceData'
        ));
    }
    
    

    


    
    


    
    
}
