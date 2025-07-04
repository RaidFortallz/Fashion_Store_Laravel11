@extends('themes.jawique.layouts.app')

@section('content')

<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
      <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Products</li>
          </ol>
        </nav>
      </div>
    </section>
    <section class="main-content">
      <div class="container">
        <div class="row">
          <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
            
            @include('themes.jawique.products.sidebar', ['categories' => $categories])

          </aside>
          <section class="col-lg-9 col-md-12 products">
            <div class="card mb-4 bg-body-tertiary border-0 section-header">
              <div class="card-body p-5">
                <h2 class="mb-0">Tag: {{ $tag->name }}</h2>
              </div>
            </div>
            <div class="row">
              <div class="d-lg-flex justify-content-between align-items-center">
                <div class="mb-3 mb-lg-0">
                  &nbsp;
                </div>
                <div class="d-flex mt-2 mt-lg-0">
                  <div class="me-2 flex-grow-1">
                    <!-- select option -->
                    <select class="form-select">
                      <option selected="">Menampilkan: 50</option>
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                    </select>
                  </div>
                  <div>
                    <!-- select option -->
                    <select class="form-select">
                      <option selected="">Sort by: Terkenal</option>
                      <option value="Low to High">Harga: Bawah ke Atas</option>
                      <option value="High to Low"> Harga: Atas ke Bawah</option>
                      <option value="Release Date"> Tgl Rilis</option>
                      <option value="Avg. Rating"> Rating Rata-rata</option>
    
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              @forelse ($products as $product)
                @include('themes.jawique.products.product_box', ['product' => $product])
              @empty
                <p>Produk Kosong</p>
              @endforelse
              

            </div>

            <div class="row mt-5">
              <div class="col-12">
                {!! $products->links() !!}
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>

@endsection