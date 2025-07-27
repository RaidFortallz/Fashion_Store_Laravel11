@extends('themes.jawique.layouts.app')

@section('content')

<!-- Tampilan Detail Produk -->

    <section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/products') }}">Products</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
      </nav>
    </div>
  </section>
  <section class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div id="product-images" class="carousel slide" data-ride="carousel">
            <!-- slides -->
            <div class="carousel-inner">
              @foreach ($product->images as $key => $image)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                  <img src="{{ shop_product_image($image, 'img-large') }}"
                    alt="{{ $product->name }}"
                    class="d-block w-100"
                    style="height: 500px; object-fit: cover; cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#imagePreviewModal"
                    data-full="{{ shop_product_image($image, 'img-large') }}">
                </div>
              @endforeach
            </div>

            <!-- Modal Preview Gambar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body position-relative p-0">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="backdrop-blur position-absolute top-0 start-0 w-100 h-100" style="z-index: -1; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(8px);"></div>
        <img id="modalImage" src="" alt="Preview Gambar" class="img-fluid mx-auto d-block rounded shadow-lg" style="max-height: 90vh; object-fit: contain;">
      </div>
    </div>
  </div>
</div>


             <!-- Left right -->
            <button class="carousel-control-prev" type="button" data-bs-target="#product-images"
              data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#product-images"
              data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
            <!-- Thumbnails -->
            <ol class="carousel-indicators list-inline mt-3">
              @foreach ($product->images as $key => $image)
                <li class="list-inline-item {{ $key == 0 ? 'active' : '' }}">
                  <a href="" id="carousel-selector-{{ $key }}"
                  data-bs-target="#product-images"
                  data-bs-slide-to="{{ $key }}"
                  class="{{ $key == 0 ? 'active' : '' }}">
                <img src="{{ shop_product_image($image, 'img-thumb') }}" class="img-fluid" style="height: 60px; width: auto; object-fit: cover" alt=""></a>
                </li>
              @endforeach
            </ol>
          </div>
        </div>
        <div class="col-md-6">
          <div class="product-detail mt-6 mt-md-0">
            <h1 class="mb-1">{{ $product->name }}</h1>
            <div class="mb-3 rating">
              <small class="text-warning">
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star-half"></i>
              </small>
              <a href="#" class="ms-2">(30 reviews)</a>
            </div>
            <div class="price">
                @if ($product->hasSalePrice)
                    <span class="active-price text-dark">Rp {{ $product->sale_price_label }}</span>
                    <span class="text-decoration-line-through text-muted ms-1">{{ $product->price_label }}</span>
                    <span><small class="discount-percent ms-2 text-danger">{{ $product->discount_percent }}% Off</small></span>
                @else
                    <span class="active-price text-dark">Rp {{ $product->price_label }}</span>
                @endif
            </div>
            <hr class="my-6">
              @include('themes.jawique.shared.flash')
              {{ html()->form('post', route('carts.store'))->open() }}

              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <div style="width: 100px;">
                <input type="number" name="qty" value="1" class="form-control" min="1" />
              </div>
              
              <button type="submit" class="btn btn-add-cart">
                <i class='bx bx-cart'></i> Tambah ke keranjang
              </button>
              
                <a class="btn btn-light" href="shop-wishlist.html" data-bs-toggle="tooltip"
                  aria-label="Wishlist"><i class="bx bx-heart"></i></a>
              </div>
              {{ html()->form()->close() }}

            </div>
            <hr class="my-6">
            <div class="product-info">
              <table class="table table-borderless mb-0">
                <tbody>
                  <tr>
                    <td>SKU:</td>
                    <td>{{ $product->sku }}</td>
                  </tr>
                  <tr>
                    <td>Stok:</td>
                    <td>{{ $product->stock_status_label }}</td>
                  </tr>
                  <tr>
                    <td>Type:</td>
                    <td>Fruits</td>
                  </tr>
                  <tr>
                    <td>Shipping:</td>
                    <td><small>01 day shipping.<span class="text-muted">( Free pickup today)</span></small></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <br>
            <p>{!! $product->excerpt !!}</p>
            <hr class="my-6">
            <div class="product-share">
              <ul>
                <li><a href="#"><i class="bx bxl-facebook-circle"></i></a></li>
                <li><a href="#"><i class="bx bxl-pinterest"></i></a></li>
                <li><a href="#"><i class="bx bxl-whatsapp"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="product-description pt-5">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-product-details-tab" data-bs-toggle="tab"
                data-bs-target="#nav-product-details" type="button" role="tab" aria-controls="nav-product-details"
                aria-selected="true">Details</button>
              <button class="nav-link" id="nav-product-reviews-tab" data-bs-toggle="tab"
                data-bs-target="#nav-product-reviews" type="button" role="tab" aria-controls="nav-product-reviews"
                aria-selected="false">Reviews</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="nav-product-details" role="tabpanel"
              aria-labelledby="nav-product-details-tab">
              <div class="my-8">
                <p>{!! $product->body !!}</p>
              </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-product-reviews" role="tabpanel"
              aria-labelledby="nav-product-reviews-tab">
              <div class="review-form">
                <h3>Write a review</h3>
                <form>
                  <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Your Review</label>
                    <textarea cols="4" class="form-control"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection



@push('scripts')
<script>
  let clickedImage = null;

  // Saat gambar diklik, simpan elemennya
  document.querySelectorAll('.carousel-inner img').forEach(img => {
  img.addEventListener('click', function () {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = this.src;

    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
  });
});

  // Saat modal sudah tampil penuh, baru inject src
  const imagePreviewModal = document.getElementById('imagePreviewModal');
  imagePreviewModal.addEventListener('shown.bs.modal', function () {
    if (clickedImage) {
      const modalImg = document.getElementById('modalImage');
      modalImg.src = clickedImage.dataset.full;
    }
  });

  // Bersihkan gambar saat modal ditutup (optional)
  imagePreviewModal.addEventListener('hidden.bs.modal', function () {
    const modalImg = document.getElementById('modalImage');
    modalImg.src = '';
    clickedImage = null;
  });
</script>
@endpush

