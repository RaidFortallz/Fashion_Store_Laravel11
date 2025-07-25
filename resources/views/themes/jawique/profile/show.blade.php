@extends('themes.jawique.layouts.app')

@section('content')
<div class="bg-light">
    <div class="container" style="padding-top: 150px; padding-bottom: 100px;">
        <div class="row">
            <div class="col-lg-4">
                {{-- Kolom Kiri: Info Pengguna & Menu Navigasi --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="rounded-circle mb-3" alt="Avatar" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <img src="https://placehold.co/150x150/ff6f61/white?text={{ substr(Auth::user()->name, 0, 1) }}" class="rounded-circle mb-3" alt="Avatar" style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                        <h4 class="card-title mb-1">{{ Auth::user()->name }}</h4>
                        <p class="text-muted small">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                                <i class='bx bxs-user-circle me-2'></i>Profil Saya
                            </a>
                            <a class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill" href="#v-pills-address" role="tab" aria-controls="v-pills-address" aria-selected="false">
                                <i class='bx bxs-map me-2'></i>Alamat Pengiriman
                            </a>
                            <a class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">
                                <i class='bx bxs-receipt me-2'></i>Riwayat Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                {{-- Kolom Kanan: Konten Tab --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="tab-content" id="v-pills-tabContent">
                            
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <h4 class="mb-4">Edit Profil</h4>
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    {{-- ... form edit profil tetap sama ... --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Alamat Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                         @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                                         @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="avatar" class="form-label">Foto Profil</label>
                                        <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="avatar" name="avatar">
                                        <div class="form-text">Format yang didukung: JPG, PNG, GIF. Ukuran maks: 2MB.</div>
                                        @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success-custom">Simpan Perubahan</button>
                                        <a href="{{ url('/') }}" class="btn btn-first smooth-redirect">Kembali</a>
                                    </div>
                                </form>
                            </div>

                            {{-- KODE DIPERBAIKI: Tab Alamat dengan daftar dan form --}}
<div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
    <h4 class="mb-4">Alamat Pengiriman</h4>
    
    @forelse ($user->addresses as $address)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">{{ $address->first_name }} {{ $address->last_name }} 
                    @if ($address->is_primary)
                        <span class="badge bg-success ms-2">Utama</span>
                    @endif
                </h6>
                <p class="card-text small text-muted mb-1">
                    {{ $address->phone }} 
                    @if ($address->email)
                        <br>{{ $address->email }}
                    @endif
                </p>
                <p class="card-text small text-muted">
                    {{ $address->address1 }}
                    @if ($address->address2)
                        , {{ $address->address2 }}
                    @endif
                    , {{ $address->city }}, {{ $address->province }} {{ $address->postcode }}
                </p>
                @if ($address->label)
                    <p class="card-text small fw-bold">Tipe: {{ $address->label }}</p>
                @endif
                <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus alamat ini?');" class="d-inline-block me-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
                @if (!$address->is_primary)
                    <form action="{{ route('addresses.set_primary', $address) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PUT') <button type="submit" class="btn btn-sm btn-outline-primary">Set Utama</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Anda belum menambahkan alamat pengiriman.</p>
    @endforelse

    <hr class="my-4">

    <h5 class="mb-3">Tambah Alamat Baru</h5>
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
                    <button type="submit" class="btn btn-success-custom">Tambah Alamat</button>
                </form>
                </div>

                            <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                                <h4 class="mb-4">Riwayat Pesanan</h4>
                                <p class="text-muted">Anda belum memiliki riwayat pesanan.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
