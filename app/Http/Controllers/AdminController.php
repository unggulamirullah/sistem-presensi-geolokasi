<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function exportAttendances(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
        ]);

        $month = $request->month;
        $year = $request->year;

        $attendances = Attendance::with('employee.user')
            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->orderBy('attendance_date', 'asc')
            ->get();

        $fileName = 'laporan_presensi_' . $year . '_' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal', 'NIK', 'Nama Karyawan', 'Departemen', 'Posisi', 'Jam Masuk', 'Jam Pulang', 'Status', 'Jarak (Meter)'];

        $callback = function() use($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $attendance) {
                $row = [
                    $attendance->attendance_date,
                    $attendance->employee->employee_number,
                    $attendance->employee->user->name,
                    $attendance->employee->department,
                    $attendance->employee->position,
                    $attendance->check_in_time ?? '-',
                    $attendance->check_out_time ?? '-',
                    $attendance->status,
                    $attendance->distance_meter ?? '-'
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
