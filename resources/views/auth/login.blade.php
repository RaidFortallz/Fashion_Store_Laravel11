@extends('themes.jawique.layouts.auth')

@section('content')
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            const icon = this.querySelector("i");

            // Ganti ikon sesuai mode
            if (type === "password") {
                icon.classList.remove("bx-hide");
                icon.classList.add("bx-show");
            } else {
                icon.classList.remove("bx-show");
                icon.classList.add("bx-hide");
            }
        });
    });
</script>
@endpush

<div class="container-fluid vh-100 p-0">
    <div class="row g-0 h-100">
        
        <!-- Kolom Kiri: Gambar dengan Overlay Teks -->
        <div class="col-md-7 d-none d-md-flex justify-content-center align-items-center text-white" 
             style="background: linear-gradient(to right, rgba(255, 111, 97, 0.8), rgba(255, 236, 210, 0.8)), url('{{ asset('images/fashion.jpg') }}') center/cover no-repeat;">
            <div class="text-center p-5" style="max-width: 500px;">
                <h1 class="display-4" style="font-family: 'Merriweather', serif; font-weight: 700;">Selamat Datang Kembali di JawiQue</h1>
                <p class="lead mt-3">Temukan tren dan gaya terbaru, dengan produk Lokal terbaik khusus untuk Anda.</p>
            </div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="col-md-5 d-flex justify-content-center align-items-center bg-white">
            <div class="p-4 p-md-5 w-100" style="max-width: 500px;">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold" style="color: #3B3A60;">Masuk ke Akun Anda</h2>
                    <p class="text-muted">Masukkan kredensial Anda untuk mengakses akun.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Input Email -->
                    <div class="input-group-auth mb-4 shadow-sm w-100" style="border-radius: 0.5rem; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 px-3"><i class='bx bx-envelope text-muted'></i></span>
                        <input id="email" type="email" class="form-control w-100 border-start-0 py-2 @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Alamat Email">
                        @error('email')
                            <span class="invalid-feedback d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="input-group-auth mb-3 shadow-sm w-100" style="border-radius: 0.5rem; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 px-3">
                            <i class='bx bx-lock-alt text-muted'></i>
                        </span>
                        <input id="password" type="password" class="form-control border-start-0 border-end-0 py-2 @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Kata Sandi">
                        <span class="input-group-text bg-white px-3" id="togglePassword" style="cursor: pointer;">
                            <i class='bx bx-show text-muted'></i>
                        </span>
                        @error('password')
                            <span class="invalid-feedback d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me & Lupa Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #ff6f61; font-size: 0.9rem;">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login-auth fw-bold py-2">
                            Masuk
                        </button>
                    </div>
                    
                    <!-- Pembatas "OR" -->
                    <div class="row my-4 align-items-center">
                        <div class="col"><hr></div>
                        <div class="col-auto text-muted" style="font-size: 0.9rem;">ATAU</div>
                        <div class="col"><hr></div>
                    </div>

                    <!-- Tombol Login Google -->
                    <div class="d-grid">
                        <a href="#" class="btn btn-outline-secondary d-flex align-items-center justify-content-center py-2"
                           onclick="alert('Fitur belum tersedia')">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" style="width: 20px; margin-right: 10px;">
                            Login dengan Google
                        </a>
                    </div>

                    <!-- Link ke Halaman Register -->
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #ff6f61;">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
