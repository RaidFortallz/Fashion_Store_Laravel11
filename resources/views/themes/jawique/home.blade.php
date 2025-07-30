@extends('themes.jawique.layouts.app')

@section('content')

@include('themes.jawique.shared.slider')

<section class="popular py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Sedang Diskon</h1>
            <a href="{{ route('products.discount') }}" class="btn-first">Lihat Semua <i class='bx bx-right-arrow-alt ms-1'></i></a>
        </div>

        <div class="row">
            @forelse ($popularProducts ?? [] as $product)
                <div class="col-lg-3 col-6 mb-4">
                    <div class="card card-product border shadow-sm h-100">
                        <div class="card-img-wrapper overflow-hidden">
                            <a href="{{ route('products.show', ['categorySlug' => $product->categories->first()->slug ?? 'produk', 'productSlug' => $product->slug]) }}">
                                @if ($product->hasMedia('products'))
                                    <img src="{{ $product->getFirstMediaUrl('products', 'large') }}" class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <img src="https://placehold.co/280x400/e1e1e1/7f7f7f?text=No+Image" class="card-img-top" alt="Gambar Tidak Tersedia">
                                @endif
                            </a>
                            <div class="card-actions">
                                @guest
                                    <a href="javascript:void(0)" onclick="showLoginAlert()" class="btn btn-cart"><i class='bx bx-cart'></i></a>
                                @else
                                    <form action="{{ route('carts.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-cart">
                                            <i class='bx bx-cart'></i>
                                        </button>
                                    </form>
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
                <div class="col"><p class="text-center">Tidak ada produk diskon saat ini.</p></div>
            @endforelse
        </div>
    </div>
</section>

<section class="latest py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Produk Terbaru</h1>
            <a href="{{ route('products.index') }}?sort=publish_date&order=desc" class="btn-first">Lihat Semua <i class='bx bx-right-arrow-alt ms-1'></i></a>
        </div>

        <div class="row">
            @forelse ($latestProducts ?? [] as $product)
                <div class="col-lg-3 col-6 mb-4">
                    <div class="card card-product border shadow-sm h-100">
                        <div class="card-img-wrapper overflow-hidden">
                             <a href="{{ route('products.show', ['categorySlug' => $product->categories->first()->slug ?? 'produk', 'productSlug' => $product->slug]) }}">
                                @if ($product->hasMedia('products'))
                                    <img src="{{ $product->getFirstMediaUrl('products', 'large') }}" class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <img src="https://placehold.co/280x400/e1e1e1/7f7f7f?text=No+Image" class="card-img-top" alt="Gambar Tidak Tersedia">
                                @endif
                            </a>
                            <div class="card-actions">
                                @guest
                                    <a href="javascript:void(0)" onclick="showLoginAlert()" class="btn btn-cart"><i class='bx bx-cart'></i></a>
                                @else
                                    <form action="{{ route('carts.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-cart">
                                            <i class='bx bx-cart'></i>
                                        </button>
                                    </form>
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

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success') || session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success') ?? session('status')),
        confirmButtonColor: '#32b37a',
        timer: 3000
    });
</script>
@endif
@endpush
