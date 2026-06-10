@extends('layouts.app')

@section('title', 'Lokasi Kantor')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: #0f172a;">Lokasi Kantor</h2>
            <p class="text-muted">Atur titik kordinat GPS dan radius jangkauan presensi.</p>
        </div>
        <a href="{{ route('admin.office-locations.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lokasi
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
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">NAMA LOKASI</th>
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">KOORDINAT (LAT, LNG)</th>
                            <th class="px-4 py-3 text-muted small fw-semibold border-bottom-0">RADIUS PRESENSI</th>
                            <th class="px-4 py-3 text-muted small fw-semibold text-end border-bottom-0">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($locations as $location)
                        <tr>
                            <td class="px-4 py-3 fw-bold" style="color: #0f172a;">{{ $location->office_name }}</td>
                            <td class="px-4 py-3 text-muted">
                                <i class="bi bi-geo-alt text-primary me-1"></i>
                                {{ $location->latitude }}, {{ $location->longitude }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 fs-6">{{ $location->radius_meter }} Meter</span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('admin.office-locations.edit', $location->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                <form action="{{ route('admin.office-locations.destroy', $location->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lokasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-5 text-center text-muted">
                                <div class="mb-3"><i class="bi bi-map fs-1"></i></div>
                                Belum ada titik lokasi kantor. Silakan tambahkan lokasi baru.
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
