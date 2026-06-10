<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = \Illuminate\Support\Facades\Auth::user()->employee;
        
        $todayAttendance = null;
        if ($employee) {
            $todayAttendance = \App\Models\Attendance::where('employee_id', $employee->id)
                ->where('attendance_date', \Carbon\Carbon::today()->toDateString())
                ->first();
        }

        $officeLocations = \App\Models\OfficeLocation::all();

        return view('employee.dashboard', compact('todayAttendance', 'officeLocations'));
    }
}
