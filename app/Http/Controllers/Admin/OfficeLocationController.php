<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeLocation;
use Illuminate\Http\Request;

class OfficeLocationController extends Controller
{
    public function index()
    {
        $locations = OfficeLocation::latest()->get();
        return view('admin.office_locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.office_locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meter' => 'required|integer|min:1',
        ]);

        OfficeLocation::create($validated);

        return redirect()->route('admin.office-locations.index')->with('success', 'Lokasi Kantor berhasil ditambahkan.');
    }

    public function edit(OfficeLocation $officeLocation)
    {
        return view('admin.office_locations.edit', compact('officeLocation'));
    }

    public function update(Request $request, OfficeLocation $officeLocation)
    {
        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meter' => 'required|integer|min:1',
        ]);

        $officeLocation->update($validated);

        return redirect()->route('admin.office-locations.index')->with('success', 'Lokasi Kantor berhasil diperbarui.');
    }

    public function destroy(OfficeLocation $officeLocation)
    {
        $officeLocation->delete();
        return redirect()->route('admin.office-locations.index')->with('success', 'Lokasi Kantor berhasil dihapus.');
    }
}
