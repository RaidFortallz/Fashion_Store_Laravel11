
<!-- UI Checkout -->

@extends('themes.jawique.layouts.app')

@section('content')

<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="main-content">
        <div class="container">
            <div class="row">
                <section class="col-lg-12 col-md-12 shopping-cart">
                    <div class="card mb-4 bg-light border-0 section-header">
                        <div class="card-body p-5">
                            <h2 class="mb-0">Checkout</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-md-6">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0"><i class='bx bx-map'></i> Alamat Pengiriman</h5>
                                <a href="#" class="btn btn-outline-secondary btn-sm">Tambah alamat baru</a>
                            </div>
                            <div class="mt-3">
                                <div class="row">
                                    @forelse ($addresses as $address)
                                                                        
                                    <div class="col-lg-6 col-12 mb-4">
                                        <div class="card card-body p-6 {{ $address->is_primary ? 'bg-white border-danger' : '' }}">
                                            <div class="form-check mb-4">
                                                <input class="form-check-input delivery-address" value="{{ $address->id }}" type="radio" name="address_id"
                                                    id="homeRadio_{{ $address->id }}" {{ $address->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="homeRadio">{{ $address->label }}</label>
                                            </div>
                                            <!-- alamat -->
                                            <address>
                                                <strong>{{ $address->first_name }} {{ $address->last_name }}</strong>
                                                <br>

                                                {{ $address->address1 }}
                                                <br>

                                                {{ $address->address2 }}
                                                <br>

                                                <abbr title="Phone">No HP: {{ $address->phone }}</abbr>
                                            </address>
                                            @if ($address->is_primary)
                                                <span class="text-danger">Alamat Utama</span>    
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                        <div class="col-12">
                                            <p>Alamat tidak ditemukan</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <h5 class="mb-0"><i class='bx bxs-truck'></i> Layanan Pengiriman</h5>
                            <div class="mt-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input courier_code" type="radio" name="courier_code" id="inlineRadio1"
                                        value="jne">
                                    <label class="form-check-label" for="inlineRadio1">JNE</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input courier_code" type="radio" name="courier_code" id="inlineRadio2"
                                        value="pos">
                                    <label class="form-check-label" for="inlineRadio2">POS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input courier_code" type="radio" name="courier_code" id="inlineRadio2"
                                        value="tiki">
                                    <label class="form-check-label" for="inlineRadio2">TIKI</label>
                                </div>
                            </div>
                            <div class="mt-3 available-wrapper" style="display: none;">
                                <p>Layanan Kurir tersedia:</p>
                                <ul class="list-group list-group-flush available-services">
                                    
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="#!" class="btn btn-second">Kembali ke keranjang belanja</a>
                                <a href="#!" class="btn btn-first">Buat Pesanan</a>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 col-md-6">
                            <div class="mb-5 card mt-6 shadow">
                                <div class="card-body p-6">
                                    <!-- heading -->
                                    <h2 class="h5 mb-4">Detail Pesanan</h2>
                                    <ul class="list-group list-group-flush">
                                    @foreach ($cart->items as $item)
                                    <li class="list-group-item py-3 {{ ($loop->index == 0) ? 'border-top' : '' }}">
                                        <div class="row align-items-center">
                                            <div class="col-6 col-md-6 col-lg-7">
                                                <div class="d-flex">
                                                    <img src="{{ asset('images/jawir.jpg') }}" alt="Ecommerce" style="height: 70px;">
                                                    <div class="ms-3">
                                                        <a href="{{ shop_product_link($item->product) }}">
                                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                        </a>
                                                        <span>
                                                            @if ($item->product->has_sale_price)
                                                            <small>Rp {{ $item->product->sale_price_label }}</small>
                                                            <small class="text-muted text-decoration-line-through">{{ $item->product->price_label }}</small>
                                                            @else
                                                            <small>Rp {{ $item->product->price_label }}</small>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-2 col-lg-2">
                                                1
                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                @if ($item->product->has_sale_price)
                                                <span class="fw-bold">Rp {{ $item->product->sale_price_label }}</span>
                                                @else
                                                <span class="fw-bold">Rp {{ $item->product->price_label }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach

                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>Item Subtotal</div>
                                            <div class="fw-bold">Rp {{ $cart->base_total_price_label }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>Diskon</div>
                                            <div class="fw-bold">Rp {{ $cart->discount_amount_label }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>Biaya Admin (11%)</div>
                                            <div class="fw-bold">Rp {{ $cart->tax_amount_label }}</div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>Ongkos Kirim</div>
                                            <div class="fw-bold" id="shipping-fee">Rp 0</div>
                                        </div>

                                    </li>
                                    <li class="list-group-item py-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 fw-bold">
                                            <div>Grand Total</div>
                                            <div id="grand-total">Rp {{ $cart->grand_total_label }}</div>
                                        </div>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    @endsection