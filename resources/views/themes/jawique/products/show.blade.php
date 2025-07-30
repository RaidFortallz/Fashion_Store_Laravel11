@extends('themes.jawique.layouts.app')

@section('content')

<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/products') }}">Produk</a></li>
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
                    <div class="carousel-inner">
                        @forelse ($product->getMedia('products') as $key => $media)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ $media->getUrl() }}"
                                     alt="{{ $product->name }}"
                                     class="d-block w-100"
                                     style="height: 500px; object-fit: cover; cursor: pointer;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imagePreviewModal"
                                     data-full="{{ $media->getUrl() }}">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://placehold.co/800x500/e1e1e1/7f7f7f?text=Gambar+Tidak+Tersedia"
                                     alt="Gambar Tidak Tersedia"
                                     class="d-block w-100"
                                     style="height: 500px; object-fit: cover;">
                            </div>
                        @endforelse
                    </div>

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

                    <button class="carousel-control-prev" type="button" data-bs-target="#product-images" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#product-images" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <ol class="carousel-indicators list-inline mt-3">
                        @foreach ($product->getMedia('products') as $key => $media)
                            <li class="list-inline-item {{ $key == 0 ? 'active' : '' }}">
                                <a href="#" id="carousel-selector-{{ $key }}"
                                   data-bs-target="#product-images"
                                   data-bs-slide-to="{{ $key }}"
                                   class="{{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl() }}" class="img-fluid" style="height: 60px; width: auto; object-fit: cover" alt="thumbnail">
                                </a>
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
                        {{ html()->form()->close() }}

                        @php
                            $isFavorited = auth()->check() && auth()->user()->favorites->contains($product->id);
                        @endphp
                        <form method="POST" action="{{ route('favorite.toggle', $product->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-light" data-bs-toggle="tooltip" title="Tambahkan ke favorit">
                                <i class="{{ $isFavorited ? 'bx bxs-heart text-danger' : 'bx bx-heart' }} "></i>
                            </button>
                        </form>
                        
                    </div>

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
                                <td>{{ $product->type ? ucfirst($product->type) : 'Tidak ada tipe' }}</td>
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
        <div class="row">
            <div class="product-description pt-5">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-product-details-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-product-details" type="button" role="tab" aria-controls="nav-product-details"
                                aria-selected="true">Detail</button>
                        <button class="nav-link" id="nav-product-reviews-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-product-reviews" type="button" role="tab" aria-controls="nav-product-reviews"
                                aria-selected="false">Review</button>
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
                            <h3>Tuliskan ulasan</h3>
                            <form>
                                <div class="form-group">
                                    <label>Nama Kamu</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Ulasan Kamu</label>
                                    <textarea cols="4" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
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
    document.addEventListener('DOMContentLoaded', function () {
        const imagePreviewModal = document.getElementById('imagePreviewModal');
        
        if (imagePreviewModal) {
            const modalImage = imagePreviewModal.querySelector('#modalImage');

            document.querySelectorAll('#product-images .carousel-inner img').forEach(img => {
                img.addEventListener('click', function () {
                    if (modalImage) {
                        modalImage.src = this.dataset.full;
                    }
                });
            });

            imagePreviewModal.addEventListener('hidden.bs.modal', function () {
                if (modalImage) {
                    modalImage.src = '';
                }
            });
        }
    });
</script>
@endpush
