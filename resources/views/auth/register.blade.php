@extends('themes.jawique.layouts.auth')

@section('content')
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function setupToggle(idInput, idToggle) {
            const input = document.getElementById(idInput);
            const toggle = document.getElementById(idToggle);

            toggle.addEventListener("click", function () {
                const type = input.getAttribute("type") === "password" ? "text" : "password";
                input.setAttribute("type", type);
                const icon = this.querySelector("i");
                icon.classList.toggle("bx-show");
                icon.classList.toggle("bx-hide");
            });
        }

        setupToggle("password", "togglePassword");
        setupToggle("password-confirm", "toggleConfirm");
    });
</script>
@endpush

<div class="container-fluid vh-100 p-0">
    <div class="row g-0 h-100">

        <!-- Kolom Kiri -->
        <div class="col-md-7 d-none d-md-flex justify-content-center align-items-center text-white"
             style="background: linear-gradient(to right, rgba(50, 179, 122, 0.8), rgba(255, 236, 210, 0.8)), url('{{ asset('images/fashion.jpg') }}') center/cover no-repeat;">
            <div class="text-center p-5" style="max-width: 500px;">
                <h1 class="display-4" style="font-family: 'Merriweather', serif; font-weight: 700;">Gabung bersama JawiQue</h1>
                <p class="lead mt-3">Daftar dan temukan fashion lokal terbaik yang sesuai dengan gayamu.</p>
            </div>
        </div>

        <!-- Kolom Kanan: Form Register -->
        <div class="col-md-5 d-flex justify-content-center align-items-center bg-white">
            <div class="p-4 p-md-5 w-100" style="max-width: 500px;">

                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="color: #3B3A60;">Buat Akun Baru</h2>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="input-group-auth mb-3 shadow-sm w-100" style="border-radius: 0.5rem; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 px-3">
                            <i class='bx bx-user text-muted'></i>
                        </span>
                        <input type="text" name="name"
                               class="form-control border-start-0 py-2 @error('name') is-invalid @enderror"
                               placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="input-group-auth mb-3 shadow-sm w-100" style="border-radius: 0.5rem; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 px-3">
                            <i class='bx bx-envelope text-muted'></i>
                        </span>
                        <input id="email" type="email" name="email"
                               class="form-control border-start-0 py-2 @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="Alamat Email">
                        @error('email')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group-auth mb-3 shadow-sm w-100" style="border-radius: 0.5rem; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 px-3">
                            <i class='bx bx-lock-alt text-muted'></i>
                        </span>
                        <input id="password" type="password" name="password"
                               class="form-control border-start-0 border-end-0 py-2 @error('password') is-invalid @enderror"
                               required placeholder="Kata Sandi">
                        <span class="input-group-text bg-white px-3" id="togglePassword" style="cursor: pointer;">
                            <i class='bx bx-show text-muted'></i>
                        </span>
                        @error('password')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="input-group-auth mb-4 shadow-sm w-100" style="border-radius: 0.5rem; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 px-3">
                            <i class='bx bx-lock text-muted'></i>
                        </span>
                        <input id="password-confirm" type="password" name="password_confirmation"
                               class="form-control border-start-0 border-end-0 py-2"
                               placeholder="Konfirmasi Kata Sandi" required>
                        <span class="input-group-text bg-white px-3" id="toggleConfirm" style="cursor: pointer;">
                            <i class='bx bx-show text-muted'></i>
                        </span>
                    </div>

                    <!-- Tombol Register -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-regist-auth fw-bold py-2">Daftar</button>
                    </div>

                    <!-- OR -->
                    <div class="row my-4 align-items-center">
                        <div class="col"><hr></div>
                        <div class="col-auto text-muted" style="font-size: 0.9rem;">ATAU</div>
                        <div class="col"><hr></div>
                    </div>

                    <!-- Tombol Google -->
                    <div class="d-grid mb-3">
                        <a href="#" class="btn btn-outline-secondary d-flex align-items-center justify-content-center py-2"
                           onclick="alert('Fitur belum tersedia')">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" style="width: 20px; margin-right: 10px;">
                            Daftar dengan Google
                        </a>
                    </div>

                    <!-- Link Login -->
                    <div class="text-center">
                        <p class="text-muted mb-0">Sudah punya akun? 
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #32b37a;">Masuk di sini</a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
