<div class="col-lg-3 col-6">
    <div class="card card-product card-body p-lg-4 p3">
        <div class="text-center position-relative" style="height: 200px; overflow: hidden;">
            <a href="{{ route('products.show', ['categorySlug' => $product->categories->first()->slug ?? 'produk', 'productSlug' => $product->slug]) }}">
                @if ($product->hasMedia('products'))
                    <img src="{{ $product->getFirstMediaUrl('products', 'thumb') }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid card-img-top"
                         style="height: 100%; width: 100%; object-fit: cover;">
                @else
                    <img src="https://placehold.co/250x250/e1e1e1/7f7f7f?text=No+Image" 
                         alt="Gambar Tidak Tersedia" 
                         class="img-fluid card-img-top"
                         style="height: 100%; width: 100%; object-fit: cover;">
                @endif
            </a>
        </div>
        <h3 class="product-name mt-3">{{ $product->name }}</h3>
        <div class="rating">
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
        </div>
        <div class="detail d-flex justify-content-between align-items-center mt-4">
            <p class="price">Rp {{ $product->price_label }}</p>
            
            <form action="{{ route('carts.store') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="btn-cart">
                    <i class='bx bx-cart'></i>
                </button>
            </form>
        </div>
    </div>
</div>
