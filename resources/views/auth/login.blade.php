@extends('layouts.app')

@section('title', 'Login - Sistem Presensi')

@push('styles')
<style>
    body {
        /* Gradient continues from app.blade.php */
        background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0,0,0,0.05);
        padding: 3rem;
        transition: transform 0.3s ease;
    }
    .glass-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.07);
    }
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .input-group-text {
        border-radius: 0.75rem 0 0 0.75rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        color: #64748b;
    }
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        background-color: #ffffff;
    }
    .input-group:focus-within .input-group-text {
        border-color: var(--primary-color);
        background-color: #ffffff;
        color: var(--primary-color);
    }
    .input-group:focus-within .form-control {
        border-left-color: transparent;
    }
    .form-control.border-start-0 {
        border-left-color: transparent;
    }
    .btn-primary {
        background: var(--primary-color);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.39);
    }
    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.23);
    }
</style>
@endpush

@section('content')
<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="glass-card">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #0f172a;">Selamat Datang</h3>
                    <p class="text-muted small">Silakan masuk menggunakan akun Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium small text-secondary">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="admin@perusahaan.com" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" class="form-label fw-medium small text-secondary mb-0">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-medium" style="color: var(--primary-color);">Lupa password?</a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required autocomplete="current-password">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-5 form-check">
                        <input class="form-check-input shadow-none" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted small" for="remember">
                            Ingat Saya di Perangkat Ini
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 mb-4 d-flex justify-content-center align-items-center gap-2">
                        <span>Masuk Sistem</span>
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                    
                    <div class="text-center">
                        <p class="text-muted small mb-0">Belum punya akses? <a href="#" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Hubungi Administrator</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
