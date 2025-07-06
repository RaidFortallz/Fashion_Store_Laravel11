@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="card shadow-lg d-flex flex-row overflow-hidden" 
         style="width: 1000px; height: 600px; border-radius: 15px;">

        <!-- Kolom Kiri: Gambar -->
        <div style="flex: 1; background: url('{{ asset('images/fashion.jpg') }}') center/cover no-repeat;">
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="p-5 d-flex align-items-center" style="flex: 1; background-color: #fff;">
            <div style="width: 100%;">

                <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">
                    <span style="color:#32b37a">JawiQue</span> Login
                </h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <input type="email" name="email" class="form-control rounded-pill shadow-sm py-3" 
                               placeholder="Email Address" required>
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password" class="form-control rounded-pill shadow-sm py-3" 
                               placeholder="Password" required>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember"> Remember Me </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-danger">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <div class="d-grid mb-4">
                        <button class="btn btn-success rounded-pill shadow py-2">Login</button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('register') }}" class="text-dark">Don't have an account? <b>Register</b></a>
                    </div>
                </form>

            </div>
        </div>

    </div>

</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@endsection
