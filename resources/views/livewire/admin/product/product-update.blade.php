<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Produk
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/products" wire:navigate class="btn btn-white">
                                Kembali
                            </a>
                        </span>
                        <button wire:click="update" class="btn btn-primary d-none d-sm-inline-block" type="button">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <button class="btn btn-primary d-sm-none btn-icon" aria-label="Create new product">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-md-8">
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">General</h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-warning">
                                    <div class="alert-title">Whoops!</div>
                                    Ada beberapa masalah dengan input Anda.
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label required">SKU</label>
                                    <div>
                                        <input wire:model="sku" type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" />
                                        <small class="form-hint">
                                            Kode unik untuk produk. Ex.(Kaos Polos Hitam - KPL0001)
                                        </small>
                                        @error('sku')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Nama</label>
                                    <div>
                                        <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" />
                                        <small class="form-hint">
                                            slug : /product/{{ $product->slug }}
                                        </small>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi Singkat</label>
                                    <textarea wire:model="excerpt" class="summernote form-control @error('excerpt') is-invalid @enderror"></textarea>
                                    @error('excerpt')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Detail</label>
                                    <textarea wire:model="body" class="summernote form-control @error('body') is-invalid @enderror"></textarea>
                                    @error('body')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Foto Produk (jpeg/png/jpg min:50kb - max:4mb)</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Unggah Foto (bisa lebih dari 1 foto)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" wire:model="image" />
                                    @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Foto Produk</label>
                                    <small class="form-hint mb-3">
                                        Klik untuk menjadikan foto sampul/thumbnail.
                                    </small>
                                    <div class="row g-2">
                                        @foreach ($product->getMedia('products') as $media)
                                            <div class="col-6 col-sm-2 position-relative">
                                                <button wire:click="deleteImage('{{ $media->id }}')" 
                                                        type="button" 
                                                        class="btn btn-danger"
                                                        style="position: absolute; top: 5px; right: 5px; z-index: 10; font-size: 1.2em; padding: 0px 8px; line-height: 1; border-radius: 25%; opacity: 0.8;"
                                                        title="Hapus Gambar">
                                                    &times;
                                                </button>

                                                <label class="form-imagecheck mb-2">
                                                    <input wire:click="setFeaturedImage('{{ $media->id }}')" 
                                                        name="form-imagecheck-radio" 
                                                        type="radio" 
                                                        {{ ($product->featured_image == $media->id) ? 'checked' : ''}} 
                                                        value="1" 
                                                        class="form-imagecheck-input">
                                                    
                                                    <span class="form-imagecheck-figure">
                                                        <img src="{{ $media->getUrl() }}" 
                                                            alt="{{ $media->name }}" 
                                                            class="form-imagecheck-image">
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Setelan</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <div>
                                    <select wire:model="status" class="form-control @error('status') is-invalid @enderror">
                                        <option disabled>-- Status --</option>
                                        <option value="INACTIVE">Inactive</option>
                                        <option value="ACTIVE">Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Setelan Harga</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Harga</label>
                                <div>
                                    <input wire:model="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Jual (Promo)</label>
                                <div>
                                    <input wire:model.defer="sale_price" type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" />
                                    <small class="form-hint">
                                        Harga Jual (opsional)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kelola Stok</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-check">
                                            <input wire:model="manage_stock" wire:change="changeManageStock" class="form-check-input" type="checkbox" />
                                            <span class="form-check-label">aktifkan pengelolaan stok?</span>
                                        </label>
                                    </div>
                                </div>
                                @if ($manage_stock)
                                <div class="mb-3">
                                    <label class="form-label required">Stok</label>
                                    <div>
                                        <input wire:model="qty" type="number" class="form-control @error('qty') is-invalid @enderror" name="qty" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Batas Stok Minimum</label>
                                    <div>
                                        <input wire:model="low_stock_threshold" type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror" name="low_stock_threshold" />
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>