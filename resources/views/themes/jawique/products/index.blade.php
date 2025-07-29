@extends('themes.jawique.layouts.app')

@section('content')

<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ '/' }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
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
                        <h2 class="mb-0">
                            @if (request('q'))
                                Hasil pencarian: "{{ request('q') }}"
                            @else
                                Produk
                                @if (request('sort') && request('order'))
                                    <small class="text-muted d-block mt-2" style="font-size: 18px;">
                                        Disortir berdasarkan:
                                        @switch(request('sort'))
                                            @case('price')
                                                Harga ({{ request('order') === 'asc' ? 'Termurah ke Termahal' : 'Termahal ke Termurah' }})
                                                @break
                                            @case('publish_date')
                                                Produk Terbaru
                                                @break
                                        @endswitch
                                    </small>
                                @endif
                            @endif
                        </h2>
                    </div>
                </div>

                <div class="row">
                    <div class="d-lg-flex justify-content-between align-items-center">
                        <div class="mb-3 mb-lg-0">&nbsp;</div>
                        <div class="d-flex mt-2 mt-lg-0">
                            <div class="me-2 flex-grow-1">&nbsp;</div>
                            <div>
                                <select class="form-select" onchange="window.location.href=this.value">
                                @foreach ($sortingOptions as $url => $label)
                                    <option value="{{ url()->current() . $url }}" {{ $sortingQuery === $url ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
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
