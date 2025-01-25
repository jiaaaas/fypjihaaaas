<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function dashboard(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        $attendance = Attendance::where('employee_id', $request->employee_id)->count();

        $late = Attendance::where('employee_id', $request->employee_id)
            ->where('status', 'late')
            ->whereYear('created_at', now()->year)
            ->count();

        $present = Attendance::where('employee_id', $request->employee_id)->where('status', 'present')->count();
        
        $absent = Attendance::where('employee_id', $request->employee_id)
            ->where('status', 'absent')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereTime('created_at', '>', '12:00:00')
            ->count();

        $daysInMonth = now()->daysInMonth;
        $absentDates = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = now()->startOfMonth()->addDays($day - 1)->toDateString();
            $attendanceExists = Attendance::where('employee_id', $request->employee_id)
            ->whereDate('created_at', $date)
            ->exists();

            if (!$attendanceExists) {
            $absentDates[] = $date;
            Attendance::create([
                'employee_id' => $request->employee_id,
                'status' => 'absent',
                'created_at' => $date . ' 00:00:00',
            ]);
            }
        }

        $absent += count($absentDates);

        return response()->json([
            // 'no. of attendance' => $attendance,
            'no. of late' => $late,
            'no. of present' => $present,
            'no. of absent' => $absent,
        ]);}

}
    

?>

