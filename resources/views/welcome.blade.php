@extends('layouts.app')

@section('title', 'Beranda - Sistem Presensi Ayuri Kreasi Nusantara')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(79, 70, 229, 0.08) 0%, transparent 70%);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .feature-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem;
        height: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: rgba(79, 70, 229, 0.2);
    }
    
    .icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        transition: all 0.3s ease;
    }

    .feature-card:hover .icon-wrapper {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }
    
    .text-gradient {
        background: linear-gradient(to right, var(--primary-color), #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center justify-content-between g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <div class="d-inline-block mb-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium border border-primary border-opacity-25">
                        <i class="bi bi-stars me-1"></i> Sistem Cerdas & Real-time
                    </span>
                </div>
                <h1 class="display-4 fw-bold mb-4" style="color: #0f172a; letter-spacing: -1px; line-height: 1.2;">
                    Sistem Presensi Karyawan <br>
                    <span class="text-gradient">Berbasis Geolokasi</span>
                </h1>
                <p class="lead text-muted mb-5 fs-5" style="line-height: 1.6;">
                    Tingkatkan kedisiplinan dan akurasi absensi tim Anda di <strong>Ayuri Kreasi Nusantara</strong>. Lakukan presensi masuk dan pulang dengan mudah, hanya ketika Anda berada di dalam radius kantor.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm fw-semibold d-flex align-items-center justify-content-center gap-2">
                        Masuk ke Dashboard
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="position-relative">
                    <div class="bg-white p-2 rounded-4 shadow-lg position-relative" style="z-index: 2;">
                        <!-- Using a nice placeholder image relevant to office work -->
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Office Activity" class="img-fluid rounded-3" style="object-fit: cover; height: 420px; width: 100%;">
                    </div>
                    <!-- Decorative Elements -->
                    <div class="position-absolute bg-primary rounded-circle" style="width: 150px; height: 150px; top: -30px; right: -30px; opacity: 0.15; filter: blur(30px); z-index: 1;"></div>
                    <div class="position-absolute bg-info rounded-circle" style="width: 180px; height: 180px; bottom: -40px; left: -40px; opacity: 0.15; filter: blur(40px); z-index: 1;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-bold mb-3" style="color: #0f172a;">Keunggulan Sistem Kami</h2>
            <p class="text-muted fs-5">Infrastruktur modern yang menunjang produktivitas perusahaan.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3 h5" style="color: #0f172a;">Validasi Lokasi Pintar</h4>
                    <p class="text-muted mb-0">Sistem mendeteksi koordinat GPS secara otomatis. Karyawan hanya bisa absen jika berada tepat di dalam radius area kantor.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="fw-bold mb-3 h5" style="color: #0f172a;">Pencatatan Real-time</h4>
                    <p class="text-muted mb-0">Data jam kedatangan, kepulangan, serta kalkulasi waktu keterlambatan terekam transparan di detik yang sama.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="fw-bold mb-3 h5" style="color: #0f172a;">Sistem Anti-Kecurangan</h4>
                    <p class="text-muted mb-0">Dilengkapi batas minimal akurasi GPS untuk memblokir penggunaan aplikasi lokasi palsu (Fake GPS) pada perangkat.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
