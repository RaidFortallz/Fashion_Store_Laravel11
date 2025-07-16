@extends('themes.jawique.layouts.app')

@include('themes.jawique.shared.slider')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success') || session('status'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') ?? session('status') }}',
            confirmButtonColor: '#32b37a',
            timer: 3000
        });
    });
</script>
@endif

<section class="popular py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Sedang Diskon</h1>
            <a href="#" class="btn-first">Lihat Semua <i class='bx bx-right-arrow-alt ms-1'></i></a>
        </div>

        <div class="row">
            @forelse ($popularProducts ?? [] as $product)
                <div class="col-lg-3 col-6 mb-4">
                    <div class="card card-product border shadow-sm h-100">
                        <div class="card-img-wrapper overflow-hidden">
                            <img src="{{ $product->featured_image ? asset('storage/'.$product->featured_image) : 'https://placehold.co/600x600/ff6f61/white?text=Produk' }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-actions">
                                @guest
                                    <a href="javascript:void(0)" onclick="showLoginAlert()" class="btn btn-cart"><i class='bx bx-cart'></i></a>
                                @else
                                    <a href="#" class="btn btn-cart"><i class='bx bx-cart'></i></a>
                                @endguest
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h3 class="product-name h6 mt-3">{{ $product->name }}</h3>
                            <div class="rating text-warning">
                                <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star-half'></i>
                            </div>
                            <p class="price fw-bold mb-0 mt-auto">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col"><p class="text-center">Tidak ada produk populer saat ini.</p></div>
            @endforelse
        </div>
    </div>
</section>

<section class="latest py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Produk Terbaru</h1>
            <a href="#" class="btn-first">Lihat Semua <i class='bx bx-right-arrow-alt ms-1'></i></a>
        </div>

        <div class="row">
            @forelse ($latestProducts ?? [] as $product)
                <div class="col-lg-3 col-6 mb-4">
                    <div class="card card-product border shadow-sm h-100">
                        <div class="card-img-wrapper overflow-hidden">
                            <img src="{{ $product->featured_image ? asset('storage/'.$product->featured_image) : 'https://placehold.co/600x600/ff6f61/white?text=Produk' }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-actions">
                                @guest
                                    <a href="javascript:void(0)" onclick="showLoginAlert()" class="btn btn-cart"><i class='bx bx-cart'></i></a>
                                @else
                                    <a href="#" class="btn btn-cart"><i class='bx bx-cart'></i></a>
                                @endguest
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h3 class="product-name h6 mt-3">{{ $product->name }}</h3>
                            <div class="rating text-warning">
                                <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star-half'></i>
                            </div>
                            <p class="price fw-bold mb-0 mt-auto">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col"><p class="text-center">Tidak ada produk terbaru saat ini.</p></div>
            @endforelse
        </div>
    </div>
</section>

<section class="subscribe">
    <div class="container">
        <div class="subscribe-wrapper">
            <div class="row justify-content-center text-center">
                <div class="col-lg-6 col-md-7 col-10 col-sub">
                    <h1>Subscribe Wir!</h1>
                    <form action="#" class="mt-5">
                        <div class="input-group w-100">
                            <input type="email" class="form-control" placeholder="Type your email ..">
                            <button class="btn btn-second">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
