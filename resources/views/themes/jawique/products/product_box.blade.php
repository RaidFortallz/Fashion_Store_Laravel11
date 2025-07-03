
<!-- Desain box produk -->

<div class="col-lg-3 col-6">
                <div class="card card-product card-body p-lg-4 p3">
                  <a href="{{ shop_product_link($product) }}"><img src="https://placehold.co/600x800" alt="" class="img-fluid"></a>
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
                     <a href="shop_product_link($product)" class="btn-cart"><i class='bxr  bx-cart'  ></i></a>
            </div>
    </div>
</div>