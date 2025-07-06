@extends('themes.jawique.layouts.app')

<!-- Bagian Header Menu & Slide -->
@include('themes.jawique.shared.slider')

@section('content')

{{-- SweetAlert Notifikasi Login/Register --}}
@if (session('success') || session('status'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') ?? session('status') }}',
        confirmButtonColor: '#32b37a'
    });
</script>
@endif

@if (session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif


<!-- Populer Produk -->
<section class="popular">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6">
                <h1>Popular</h1>
            </div>
            <div class="col-6 text-end">
                <a href="#" class="btn-first">View All</a>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Produk 1 -->
            <div class="col-lg-3 col-6">
                <div class="card card-body p-lg-3 p-1">
                    <img src="{{ asset('themes/jawique/assets/img/jawir.png') }}" class="img-fluid" alt="">
                    <h3 class="product-name mt-3">Jawir 1</h3>
                    <div class="rating">
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                    </div>
                    <div class="detail d-flex justify-content-between align-items-center mt-4">
                        <p class="price m-0">Rp 200.000</p>
                        <a href="#" class="btn-cart"><i class='bxr bx-cart'></i></a>
                    </div>
                </div>
            </div>

            <!-- Produk 2 -->
            <div class="col-lg-3 col-6">
                <div class="card card-body p-lg-3 p-1">
                    <img src="{{ asset('themes/jawique/assets/img/jawir.png') }}" class="img-fluid" alt="">
                    <h3 class="product-name mt-3">Jawir 2</h3>
                    <div class="rating">
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                    </div>
                    <div class="detail d-flex justify-content-between align-items-center mt-4">
                        <p class="price m-0">Rp 200.000</p>
                        <a href="#" class="btn-cart"><i class='bxr bx-cart'></i></a>
                    </div>
                </div>
            </div>

            <!-- Produk 3 -->
            <div class="col-lg-3 col-6 mt-3 mt-lg-0">
                <div class="card card-body p-lg-3 p-1">
                    <img src="{{ asset('themes/jawique/assets/img/jawir.png') }}" class="img-fluid" alt="">
                    <h3 class="product-name mt-3">Jawir 3</h3>
                    <div class="rating">
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                    </div>
                    <div class="detail d-flex justify-content-between align-items-center mt-4">
                        <p class="price m-0">Rp 200.000</p>
                        <a href="#" class="btn-cart"><i class='bxr bx-cart'></i></a>
                    </div>
                </div>
            </div>

            <!-- Produk 4 -->
            <div class="col-lg-3 col-6 mt-3 mt-lg-0">
                <div class="card card-body p-lg-3 p-1">
                    <img src="{{ asset('themes/jawique/assets/img/jawir.png') }}" class="img-fluid" alt="">
                    <h3 class="product-name mt-3">Jawir 4</h3>
                    <div class="rating">
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                    </div>
                    <div class="detail d-flex justify-content-between align-items-center mt-4">
                        <p class="price m-0">Rp 200.000</p>
                        <a href="#" class="btn-cart"><i class='bxr bx-cart'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produk Terbaru -->
<section class="latest">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6">
                <h1>Terbaru</h1>
            </div>
            <div class="col-6 text-end">
                <a href="#" class="btn-first">View All</a>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Produk Terbaru diulang -->
            <div class="col-lg-3 col-6">
                <div class="card card-body p-lg-3 p-1">
                    <img src="{{ asset('themes/jawique/assets/img/jawir.png') }}" class="img-fluid" alt="">
                    <h3 class="product-name mt-3">Jawir 1</h3>
                    <div class="rating">
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                        <i class='bxr bxs-star'></i> 
                    </div>
                    <div class="detail d-flex justify-content-between align-items-center mt-4">
                        <p class="price m-0">Rp 200.000</p>
                        <a href="#" class="btn-cart"><i class='bxr bx-cart'></i></a>
                    </div>
                </div>
            </div>
            <!-- Tambah produk lain sesuai kebutuhan -->
        </div>
    </div>
</section>

<!-- Subscribe -->
<section class="subscribe">
    <div class="container">
        <div class="subscribe-wrapper">
            <div class="row justify-content-center text-center">
                <div class="col-lg-6 col-md-7 col-10 col-sub">
                    <h1>Subscribe Wir!</h1>
                    <form action="#" class="mt-5">
                        <div class="input-group w-100">
                            <input type="email" class="form-control" placeholder="Type your email ..">
                            <button class="btn btn-outline-warning">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
