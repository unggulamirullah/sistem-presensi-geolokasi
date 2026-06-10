@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: #0f172a;">Data Karyawan</h2>
            <p class="text-muted">Kelola akun dan informasi karyawan terdaftar.</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">NAMA & EMAIL</th>
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">NIK</th>
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">POSISI & DEPARTEMEN</th>
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">STATUS</th>
                            <th class="px-4 py-3 text-muted small fw-semibold text-end border-bottom-0">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($employees as $employee)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold" style="color: #0f172a;">{{ $employee->user->name }}</div>
                                <div class="text-muted small">{{ $employee->user->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-muted">{{ $employee->employee_number }}</td>
                            <td class="px-4 py-3">
                                <div class="fw-medium text-dark">{{ $employee->position }}</div>
                                <div class="text-muted small">{{ $employee->department }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @if($employee->status)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data karyawan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-5 text-center text-muted">
                                <div class="mb-3"><i class="bi bi-inbox fs-1"></i></div>
                                Belum ada data karyawan. Silakan tambahkan karyawan pertama Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
