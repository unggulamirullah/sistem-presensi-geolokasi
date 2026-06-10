<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\OfficeLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in meters
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius of Earth in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Data karyawan tidak ditemukan untuk akun ini.');
        }

        // Check if already checked in today
        $today = Carbon::today()->toDateString();
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->where('attendance_date', $today)
            ->first();

        if ($existingAttendance) {
            return back()->with('error', 'Anda sudah melakukan Check-In hari ini.');
        }

        $lat = $request->latitude;
        $lng = $request->longitude;

        // Check distance against ALL office locations
        $offices = OfficeLocation::all();
        $isWithinRadius = false;
        $closestDistance = null;

        if ($offices->isEmpty()) {
            return back()->with('error', 'Belum ada titik lokasi kantor yang diatur oleh Admin.');
        }

        foreach ($offices as $office) {
            $distance = $this->calculateDistance($lat, $lng, $office->latitude, $office->longitude);
            
            // Keep track of the closest distance
            if (is_null($closestDistance) || $distance < $closestDistance) {
                $closestDistance = $distance;
            }

            if ($distance <= $office->radius_meter) {
                $isWithinRadius = true;
                break; // Found a valid office, stop checking
            }
        }

        if (!$isWithinRadius) {
            return back()->with('error', 'Gagal Check-In! Anda berada di luar radius kantor (Jarak terdekat: ' . round($closestDistance) . ' meter).');
        }

        // Determine Status based on time
        $now = Carbon::now();
        $checkInTime = $now->toTimeString();
        $limitTime = Carbon::createFromTime(8, 0, 0); // 08:00:00

        $status = $now->greaterThan($limitTime) ? 'Terlambat' : 'Hadir';

        // Save Attendance
        Attendance::create([
            'employee_id' => $employee->id,
            'attendance_date' => $today,
            'check_in_time' => $checkInTime,
            'check_in_latitude' => $lat,
            'check_in_longitude' => $lng,
            'distance_meter' => round($closestDistance),
            'status' => $status,
        ]);

        return back()->with('success', "Berhasil Check-In pada pukul $checkInTime. Status: $status.");
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('attendance_date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum melakukan Check-In hari ini.');
        }

        if ($attendance->check_out_time) {
            return back()->with('error', 'Anda sudah melakukan Check-Out hari ini.');
        }

        $attendance->update([
            'check_out_time' => Carbon::now()->toTimeString(),
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
        ]);

        return back()->with('success', 'Berhasil melakukan Check-Out. Terima kasih atas kerja keras Anda hari ini!');
    }
}
