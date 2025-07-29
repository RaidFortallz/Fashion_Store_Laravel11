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
                        <form action="{{ route('orders.store') }}" method="post">
                            @csrf
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0"><i class='bx bx-map'></i> Alamat Pengiriman</h5>
                                <a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">Tambah alamat baru</a>
                            </div>

                            <div class="mt-3">
                                <div class="row">
                                    @forelse ($addresses as $address)
                                    <div class="col-lg-6 col-12 mb-4">
                                        <div class="card card-body p-6 {{ $address->is_primary ? 'bg-white border-danger' : '' }}">
                                            <div class="form-check mb-4">
                                                <input class="form-check-input delivery-address" value="{{ $address->id }}" type="radio" name="address_id" id="homeRadio_{{ $address->id }}" {{ $address->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="homeRadio_{{ $address->id }}">{{ $address->label }}</label>
                                            </div>
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
                                    <input class="form-check-input courier_code" type="radio" name="courier" id="inlineRadio1" value="jne">
                                    <label class="form-check-label" for="inlineRadio1">JNE</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input courier_code" type="radio" name="courier" id="inlineRadio2" value="pos">
                                    <label class="form-check-label" for="inlineRadio2">POS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input courier_code" type="radio" name="courier" id="inlineRadio3" value="tiki">
                                    <label class="form-check-label" for="inlineRadio3">TIKI</label>
                                </div>
                            </div>
                            <div class="mt-3 available-wrapper" style="display: none;">
                                <p>Layanan Kurir tersedia:</p>
                                <ul class="list-group list-group-flush available-services">
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('carts.index') }}" class="btn btn-second">Kembali ke keranjang belanja</a>
                                <button type="submit" class="btn btn-first">Buat Pesanan</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-5 col-md-6">
                        <div class="mb-5 card mt-6 shadow">
                            <div class="card-body p-6">
                                <h2 class="h5 mb-4">Detail Pesanan</h2>
                                <ul class="list-group list-group-flush">
                                    @foreach ($cart->items as $item)
                                    <li class="list-group-item py-3 {{ ($loop->index == 0) ? 'border-top' : '' }}">
                                        <div class="row align-items-center">
                                            <div class="col-6 col-md-6 col-lg-7">
                                                <div class="d-flex">
                                                    <img src="{{ $item->product->getFirstMediaUrl('products', 'thumb') }}" alt="{{ $item->product->name }}" style="height: 70px; width: 70px; object-fit: cover;">
                                                    <div class="ms-3">
                                                        <a href="{{ route('products.show', ['categorySlug' => $item->product->categories->first()->slug ?? 'produk', 'productSlug' => $item->product->slug]) }}">
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
                                                {{ $item->qty }}
                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                @if ($item->product->has_sale_price)
                                                <span class="fw-bold">Rp {{ number_format($item->product->sale_price * $item->qty, 0, ',', '.') }}</span>
                                                @else
                                                <span class="fw-bold">Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</span>
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
                                            <div>Pajak (11%)</div>
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

<!-- Modal Tambah Alamat Baru -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="addAddressModalLabel">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Nama Depan</label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Nama Belakang</label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address1" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" name="address1" rows="3" required>{{ old('address1') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="address2" class="form-label">Detail Alamat (Opsional, ex: Blok A No. 12)</label>
                        <input type="text" class="form-control" name="address2" value="{{ old('address2') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Provinsi</label>
                            <select class="form-select @error('province') is-invalid @enderror" name="province" id="province" required>
                                <option value="">Pilih Provinsi</option>
                                <option value="JAWA BARAT" {{ old('province') == 'JAWA BARAT' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="DKI JAKARTA" {{ old('province') == 'DKI JAKARTA' ? 'selected' : '' }}>DKI Jakarta</option>
                                <option value="BANTEN" {{ old('province') == 'BANTEN' ? 'selected' : '' }}>Banten</option>
                            </select>
                            @error('province')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Kota/Kecamatan</label>
                            <select class="form-select @error('city') is-invalid @enderror" name="city" id="city" required>
                                <option value="">Pilih Kota/Kecamatan</option>
                                <optgroup label="Jawa Barat - Bandung">
                                    <option value="4870" {{ old('city') == '4870' ? 'selected' : '' }}>Bandung (Kota Bandung)</option>
                                    <option value="4871" {{ old('city') == '4871' ? 'selected' : '' }}>Bandung (Kabupaten Bandung)</option>
                                    <option value="4866" {{ old('city') == '4866' ? 'selected' : '' }}>Bandung (Kecamatan Bandung Kidul - Batununggal)</option>
                                    <option value="4816" {{ old('city') == '4816' ? 'selected' : '' }}>Bandung (Kecamatan Cileunyi)</option>
                                </optgroup>
                                <optgroup label="DKI Jakarta">
                                    <option value="268" {{ old('city') == '268' ? 'selected' : '' }}>Jakarta Pusat (Gambir)</option>
                                    <option value="252" {{ old('city') == '252' ? 'selected' : '' }}>Jakarta Utara (Kelapa Gading)</option>
                                    <option value="259" {{ old('city') == '259' ? 'selected' : '' }}>Jakarta Barat (Cengkareng)</option>
                                    <option value="255" {{ old('city') == '255' ? 'selected' : '' }}>Jakarta Selatan (Kebayoran Baru)</option>
                                    <option value="249" {{ old('city') == '249' ? 'selected' : '' }}>Jakarta Timur (Cakung)</option>
                                    <option value="360" {{ old('city') == '360' ? 'selected' : '' }}>Kepulauan Seribu (Pulau Pramuka)</option>
                                </optgroup>
                                <optgroup label="Banten">
                                    <option value="508" {{ old('city') == '508' ? 'selected' : '' }}>Tangerang (Tangerang)</option>
                                    <option value="509" {{ old('city') == '509' ? 'selected' : '' }}>Tangerang Selatan (Serpong)</option>
                                    <option value="423" {{ old('city') == '423' ? 'selected' : '' }}>Cilegon (Cibeber)</option>
                                    <option value="427" {{ old('city') == '427' ? 'selected' : '' }}>Serang (Serang)</option>
                                </optgroup>
                            </select>
                            @error('city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="postcode" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" name="postcode" value="{{ old('postcode') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Alamat</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="address_type_label" id="labelRumah" value="Rumah" {{ old('address_type_label', 'Rumah') == 'Rumah' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="labelRumah">Rumah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="address_type_label" id="labelKantor" value="Kantor" {{ old('address_type_label') == 'Kantor' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="labelKantor">Kantor</label>
                            </div>
                        </div>
                        @error('address_type_label')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-success-custom">Simpan Alamat</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
