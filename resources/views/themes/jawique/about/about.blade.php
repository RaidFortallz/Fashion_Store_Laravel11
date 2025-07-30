@extends('themes.jawique.layouts.app')

@section('content')
<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</section>

<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="mb-3">Tentang JawiQue</h1>
                <p class="lead col-md-8 mx-auto">JawiQue adalah fashion store yang didedikasikan untuk menyediakan produk lokal berkualitas tinggi dengan desain yang modern dan elegan. Kami percaya bahwa setiap orang berhak tampil percaya diri dengan gaya mereka.</p>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-12 text-center">
                <h2 class="mb-4">Tim Kami</h2>
            </div>
            @foreach ($team as $member)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                            <h5 class="card-title">{{ $member['name'] }}</h5>
                            <p class="card-text text-muted">{{ $member['role'] }}</p>
                            
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="https://instagram.com/{{ $member['instagram'] }}" target="_blank" class="text-dark fs-4">
                                    <i class='bx bxl-instagram'></i>
                                </a>
                                <a href="https://wa.me/{{ $member['whatsapp'] }}" target="_blank" class="text-dark fs-4">
                                    <i class='bx bxl-whatsapp'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
