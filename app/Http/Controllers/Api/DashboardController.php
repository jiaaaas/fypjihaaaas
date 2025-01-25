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

        $late = Attendance::where('employee_id', $request->employee_id)->where('status', 'late')->count();
        $present = Attendance::where('employee_id', $request->employee_id)->where('status', 'present')->count();

        return response()->json([
            'no. of attendance' => $attendance,
            'no. of late' => $late,
            'no. of present' => $present,
            'no. of absent' => $attendance - $present - $late,
        ]);}

}
    

?>

