@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold mb-0" style="color: #0f172a;">Tambah Karyawan Baru</h3>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-light rounded-pill px-4 text-muted border shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.employees.store') }}" method="POST">
                        @csrf
                        
                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Informasi Akun</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Alamat Email</label>
                                <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <div class="alert alert-info rounded-3 small py-2 mb-0 border-0 bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-info-circle-fill me-2"></i> Password default karyawan baru otomatis diatur ke: <strong>password123</strong>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Detail Pekerjaan</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">NIK (Nomor Induk)</label>
                                <input type="text" name="employee_number" class="form-control rounded-3 @error('employee_number') is-invalid @enderror" value="{{ old('employee_number') }}" required>
                                @error('employee_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Departemen</label>
                                <input type="text" name="department" class="form-control rounded-3 @error('department') is-invalid @enderror" value="{{ old('department') }}" required>
                                @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Jabatan / Posisi</label>
                                <input type="text" name="position" class="form-control rounded-3 @error('position') is-invalid @enderror" value="{{ old('position') }}" required>
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
