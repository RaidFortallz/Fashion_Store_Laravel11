    @extends('layouts.app')

    @section('content')
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">

        <div class="card shadow-lg d-flex flex-row overflow-hidden" 
            style="width: 1000px; height: 650px; border-radius: 15px;">

            <!-- Kolom Kiri: Gambar -->
            <div style="flex: 1; background: url('{{ asset('images/fashion.jpg') }}') center/cover no-repeat;">
            </div>

            <!-- Kolom Kanan: Form Register -->
            <div class="p-5 d-flex align-items-center" style="flex: 1; background-color: #fff;">
                <div style="width: 100%;">
                    <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">
                        <span style="color:#32b37a">JawiQue</span> Register
                    </h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <input id="name" type="text" 
                                class="form-control rounded-pill shadow-sm @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>

                            @error('name')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="email" type="email" 
                                class="form-control rounded-pill shadow-sm @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" placeholder="Email Address" required>

                            @error('email')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="password" type="password" 
                                class="form-control rounded-pill shadow-sm @error('password') is-invalid @enderror" 
                                name="password" placeholder="Password" required>

                            @error('password')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input id="password-confirm" type="password" 
                                class="form-control rounded-pill shadow-sm" 
                                name="password_confirmation" placeholder="Confirm Password" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success rounded-pill shadow py-2">Register</button>
                        </div>

                        <div class="text-center">
                            Already have an account? <a href="{{ route('login') }}" class="text-dark"><b>Login</b></a>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    @endsection
