<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/export/attendances', [App\Http\Controllers\AdminController::class, 'exportAttendances'])->name('attendances.export');
    Route::resource('employees', App\Http\Controllers\Admin\EmployeeManageController::class);
    Route::resource('office-locations', App\Http\Controllers\Admin\OfficeLocationController::class);
});

// Employee Routes
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\EmployeeController::class, 'index'])->name('dashboard');
    Route::post('/attendance/check-in', [App\Http\Controllers\Employee\AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/check-out', [App\Http\Controllers\Employee\AttendanceController::class, 'checkOut'])->name('attendance.check-out');
});
