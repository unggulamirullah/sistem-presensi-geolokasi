@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold mb-0" style="color: #0f172a;">Edit Data Karyawan</h3>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-light rounded-pill px-4 text-muted border shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Informasi Akun</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name', $employee->user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Alamat Email</label>
                                <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" value="{{ old('email', $employee->user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-semibold">Reset Password (Opsional)</label>
                                <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="Isi hanya jika ingin mengganti password">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mereset password.</small>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Detail Pekerjaan</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">NIK (Nomor Induk)</label>
                                <input type="text" name="employee_number" class="form-control rounded-3 @error('employee_number') is-invalid @enderror" value="{{ old('employee_number', $employee->employee_number) }}" required>
                                @error('employee_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Status Karyawan</label>
                                <select name="status" class="form-select rounded-3">
                                    <option value="1" {{ old('status', $employee->status) == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status', $employee->status) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Departemen</label>
                                <input type="text" name="department" class="form-control rounded-3 @error('department') is-invalid @enderror" value="{{ old('department', $employee->department) }}" required>
                                @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Jabatan / Posisi</label>
                                <input type="text" name="position" class="form-control rounded-3 @error('position') is-invalid @enderror" value="{{ old('position', $employee->position) }}" required>
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
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
