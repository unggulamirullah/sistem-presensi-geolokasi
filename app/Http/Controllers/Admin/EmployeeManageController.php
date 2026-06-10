<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeManageController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->latest()->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'employee_number' => 'required|string|max:50|unique:employees',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'employee',
        ]);

        $user->employee()->create([
            'employee_number' => $request->employee_number,
            'department' => $request->department,
            'position' => $request->position,
            'status' => true,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil ditambahkan. Password default: password123');
    }

    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->user_id)],
            'employee_number' => ['required', 'string', 'max:50', Rule::unique('employees')->ignore($employee->id)],
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $employee->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $employee->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $employee->update([
            'employee_number' => $request->employee_number,
            'department' => $request->department,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Data Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        // Delete user will cascade to employee
        $employee->user->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
