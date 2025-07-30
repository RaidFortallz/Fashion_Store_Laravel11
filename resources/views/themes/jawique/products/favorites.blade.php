@extends('themes.jawique.layouts.app')

@section('content')

<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="mb-0">Favorit Saya</h1>
            {{-- Kalau mau, bisa tambahkan tombol lihat semua favorit di sini --}}
        </div>

        <div class="row">
            @forelse ($favorites as $product)
                <div class="col-lg-3 col-6 mb-4">
                    <div class="card card-product border shadow-sm h-100">
                        <div class="card-img-wrapper overflow-hidden" style="height: 280px;">
                            <a href="{{ route('products.show', ['categorySlug' => $product->categories->first()->slug ?? 'produk', 'productSlug' => $product->slug]) }}">
                                @if ($product->hasMedia('products'))
                                    <img src="{{ $product->getFirstMediaUrl('products', 'thumb') }}" class="card-img-top" alt="{{ $product->name }}" style="object-fit: cover; height: 100%; width: 100%;">
                                @else
                                    <img src="https://placehold.co/280x400/e1e1e1/7f7f7f?text=No+Image" class="card-img-top" alt="Gambar Tidak Tersedia" style="object-fit: cover; height: 100%; width: 100%;">
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
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="bx bxs-star"></i>
                                @endfor
                            </div>
                            <p class="price fw-bold mb-0 mt-auto">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada produk favorit.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function showLoginAlert() {
    Swal.fire({
        icon: 'info',
        title: 'Harap Login',
        text: 'Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang.',
        confirmButtonColor: '#32b37a'
    });
}
</script>
@endpush
