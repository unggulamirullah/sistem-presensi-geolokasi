@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    /* Ensure map controls don't overlap awkwardly */
    #map {
        border: 2px solid #fff;
    }
</style>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #0f172a;">Dashboard Karyawan</h2>
            <p class="text-muted">Selamat datang, {{ Auth::user()->name }}. Posisikan diri Anda di dalam radius area hijau untuk presensi.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Interactive Map Container -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="map" class="rounded-4 shadow-sm" style="height: 400px; width: 100%; z-index: 1;"></div>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-fingerprint fs-1 text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Presensi Harian</h4>
                    
                    @if(!$todayAttendance)
                        <p class="text-muted mb-4">Lakukan absensi masuk Anda hari ini. Pastikan lokasi GPS Anda terdeteksi dengan baik di peta.</p>
                        <form id="form-check-in" action="{{ route('employee.attendance.check-in') }}" method="POST">
                            @csrf
                            <input type="hidden" name="latitude" id="lat_in">
                            <input type="hidden" name="longitude" id="lng_in">
                            <button type="button" id="btn-check-in" onclick="submitAttendance('form-check-in', 'lat_in', 'lng_in')" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold w-100" disabled>
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mencari Lokasi...
                            </button>
                        </form>
                    @elseif($todayAttendance && !$todayAttendance->check_out_time)
                        <div class="alert alert-info border-0 rounded-3 small text-start shadow-sm mb-4">
                            <div class="d-flex justify-content-between">
                                <span><strong>Check-In:</strong> {{ $todayAttendance->check_in_time }}</span>
                                <span class="badge bg-primary rounded-pill">{{ $todayAttendance->status }}</span>
                            </div>
                        </div>
                        <p class="text-muted mb-4">Sudah selesai bekerja? Jangan lupa Check-Out sebelum pulang.</p>
                        <form id="form-check-out" action="{{ route('employee.attendance.check-out') }}" method="POST">
                            @csrf
                            <input type="hidden" name="latitude" id="lat_out">
                            <input type="hidden" name="longitude" id="lng_out">
                            <button type="button" id="btn-check-out" onclick="submitAttendance('form-check-out', 'lat_out', 'lng_out')" class="btn btn-warning px-4 py-2 rounded-pill fw-semibold w-100 text-dark" disabled>
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mencari Lokasi...
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success border-0 rounded-3 small text-start mb-0 shadow-sm">
                            <h6 class="fw-bold text-success mb-2"><i class="bi bi-check2-all me-1"></i> Presensi Selesai</h6>
                            <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                                <span>Check In</span>
                                <strong>{{ $todayAttendance->check_in_time }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Check Out</span>
                                <strong>{{ $todayAttendance->check_out_time }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-clock-history fs-1 text-info"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Riwayat Presensi</h4>
                    <p class="text-muted mb-4">Pantau catatan waktu kedatangan dan kepulangan Anda selama bulan ini.</p>
                    <button class="btn btn-outline-primary px-4 py-2 rounded-pill fw-semibold w-100">Lihat Riwayat</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    var map;
    var userMarker;
    var userLat = null;
    var userLng = null;
    
    // Default center (can be first office or generic)
    var defaultLat = -6.200000;
    var defaultLng = 106.816666;
    
    var offices = @json($officeLocations);

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Map Center to the first office if exists
        if (offices.length > 0) {
            defaultLat = offices[0].latitude;
            defaultLng = offices[0].longitude;
        }
        
        map = L.map('map').setView([defaultLat, defaultLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Draw Office Radiuses
        offices.forEach(function(office) {
            L.circle([office.latitude, office.longitude], {
                color: '#198754', // Bootstrap success color
                fillColor: '#198754',
                fillOpacity: 0.2,
                radius: office.radius_meter
            }).addTo(map).bindPopup('<b>' + office.office_name + '</b><br>Radius Jangkauan: ' + office.radius_meter + 'm');
            
            // Add center dot for office
            L.circleMarker([office.latitude, office.longitude], {
                radius: 4,
                color: '#198754',
                fillColor: '#198754',
                fillOpacity: 1
            }).addTo(map);
        });

        // Start hunting for user location immediately
        locateUser();
    });

    function locateUser() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    userLat = position.coords.latitude;
                    userLng = position.coords.longitude;

                    // Enable buttons since we have location
                    enableButtons();

                    // Place or move user marker
                    if (!userMarker) {
                        // Create a custom red icon for user
                        var userIcon = L.divIcon({
                            className: 'custom-div-icon',
                            html: "<div style='background-color:#dc3545; width:15px; height:15px; border-radius:50%; border:2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.5);'></div>",
                            iconSize: [15, 15],
                            iconAnchor: [7, 7]
                        });
                        
                        userMarker = L.marker([userLat, userLng], {icon: userIcon}).addTo(map).bindPopup("<b>Posisi Anda Saat Ini</b>").openPopup();
                    } else {
                        userMarker.setLatLng([userLat, userLng]);
                    }

                    // Auto-pan map to user position smoothly
                    map.setView([userLat, userLng], 17, {animate: true});
                },
                function(error) {
                    alert('Gagal mendapatkan lokasi GPS. Pastikan izin lokasi (Location) aktif di browser Anda. Error: ' + error.message);
                },
                { enableHighAccuracy: false, timeout: 15000, maximumAge: 0 }
            );
        } else {
            alert("Geolocation tidak didukung oleh perangkat browser ini.");
        }
    }

    function enableButtons() {
        const btnIn = document.getElementById('btn-check-in');
        const btnOut = document.getElementById('btn-check-out');
        
        if (btnIn) {
            btnIn.innerHTML = '<i class="bi bi-box-arrow-in-right me-1"></i> Check In Sekarang';
            btnIn.disabled = false;
        }
        if (btnOut) {
            btnOut.innerHTML = '<i class="bi bi-box-arrow-right me-1"></i> Check Out Sekarang';
            btnOut.disabled = false;
        }
    }

    function submitAttendance(formId, latId, lngId) {
        if (userLat && userLng) {
            document.getElementById(latId).value = userLat;
            document.getElementById(lngId).value = userLng;
            
            // Disable button to prevent double submit spam
            const btn = document.querySelector(`#${formId} button`);
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
            btn.disabled = true;
            
            document.getElementById(formId).submit();
        } else {
            alert("Lokasi Anda belum ditemukan! Harap pastikan GPS Anda aktif dan tunggu hingga marker titik merah muncul di peta.");
            locateUser(); // Retry
        }
    }
</script>
@endsection
