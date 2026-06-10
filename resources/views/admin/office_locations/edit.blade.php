@extends('layouts.app')

@section('title', 'Edit Lokasi Kantor')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold mb-0" style="color: #0f172a;">Edit Lokasi Kantor</h3>
                <a href="{{ route('admin.office-locations.index') }}" class="btn btn-light rounded-pill px-4 text-muted border shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.office-locations.update', $officeLocation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-semibold">Nama Lokasi (Cabang/Pusat)</label>
                            <input type="text" name="office_name" class="form-control rounded-3 @error('office_name') is-invalid @enderror" value="{{ old('office_name', $officeLocation->office_name) }}" required>
                            @error('office_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Latitude</label>
                                <input type="text" name="latitude" class="form-control rounded-3 @error('latitude') is-invalid @enderror" value="{{ old('latitude', $officeLocation->latitude) }}" required>
                                @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Longitude</label>
                                <input type="text" name="longitude" class="form-control rounded-3 @error('longitude') is-invalid @enderror" value="{{ old('longitude', $officeLocation->longitude) }}" required>
                                @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label text-muted small fw-semibold">Radius Presensi (Meter)</label>
                            <div class="input-group">
                                <input type="number" name="radius_meter" class="form-control rounded-start-3 @error('radius_meter') is-invalid @enderror" value="{{ old('radius_meter', $officeLocation->radius_meter) }}" min="1" required>
                                <span class="input-group-text rounded-end-3 bg-light">Meter</span>
                            </div>
                            <small class="text-muted mt-1 d-block">Jarak maksimal karyawan diizinkan menekan tombol presensi.</small>
                            @error('radius_meter') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
