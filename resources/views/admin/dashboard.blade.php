@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #0f172a;">Dashboard Administrator</h2>
            <p class="text-muted">Selamat datang, {{ Auth::user()->name }}. Anda memiliki kendali penuh atas sistem ini.</p>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 position-relative hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-people fs-4 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Kelola Karyawan</h5>
                    </div>
                    <p class="text-muted small mb-0">Tambah, edit, atau hapus data karyawan serta atur hak akses mereka di sini.</p>
                    <a href="{{ route('admin.employees.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 position-relative hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-calendar-check fs-4 text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Laporan Presensi</h5>
                    </div>
                    <p class="text-muted small mb-0">Unduh data riwayat absen, keterlambatan, dan status kehadiran dalam format CSV.</p>
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exportModal"></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 position-relative hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-geo-alt fs-4 text-info"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Titik Lokasi Kantor</h5>
                    </div>
                    <p class="text-muted small mb-0">Atur kordinat GPS dan batas radius (geofence) yang diperbolehkan untuk melakukan absensi.</p>
                    <a href="{{ route('admin.office-locations.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export Laporan -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title fw-bold text-success" id="exportModalLabel"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Export Data Presensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.attendances.export') }}" method="GET">
          <div class="modal-body py-2">
              <div class="alert alert-info border-0 rounded-3 small text-info bg-info bg-opacity-10 mb-4">
                  File laporan akan langsung diunduh ke perangkat Anda dalam format CSV tanpa memberatkan penyimpanan server.
              </div>
              <div class="row g-3">
                  <div class="col-md-6">
                      <label class="form-label text-muted small fw-semibold">Bulan</label>
                      <select name="month" class="form-select rounded-3" required>
                          @foreach(range(1, 12) as $m)
                              <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>
                                  {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label class="form-label text-muted small fw-semibold">Tahun</label>
                      <select name="year" class="form-select rounded-3" required>
                          @foreach(range(date('Y') - 3, date('Y')) as $y)
                              <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm"><i class="bi bi-download me-1"></i> Download Laporan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
