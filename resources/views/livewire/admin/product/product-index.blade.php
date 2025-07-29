<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Produk
                    </div>
                    <h2 class="page-title">
                        Daftar Produk
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">                            
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-product-create">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                    <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Produk</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Menampilkan
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" wire:model="perPage" wire:change="changePerPage($event.target.value)" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                                    </div>
                                    entries
                                </div>
                                <div class="ms-auto text-secondary">
                                    Cari:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" wire:model.live="search" class="form-control form-control-sm" aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-3">
                        @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>SKU</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Stok</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>                                                
                                        <td>
                                            {{-- PERBAIKAN: Menggunakan cara Spatie yang baru --}}
                                            <span class="avatar me-3" style="background-image: url({{ $product->getFirstMediaUrl('products', 'thumb') }})"></span>
                                        </td>
                                        <td>
                                            {{ $product->sku }}
                                        </td>
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        <td>
                                            {{ $product->price }}
                                        </td>
                                        <td>
                                            {{ $product->status }}
                                        </td>
                                        <td>
                                            {{ $product->stock_status }}
                                        </td>
                                        
                                        <td class="text-end">
                                            <a href="{{ route('admin.products.update', [$product->id]) }}" class="btn btn-outline-primary btn-sm btn-pill w-20">Edit </a>
                                            <a wire:click="delete('{{ $product->id }}')" wire:confirm="Anda yakin ingin menghapus ini?" href="#" class="btn btn-outline-primary btn-sm btn-pill w-20"><span class="danger"> Hapus </span></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Produk kosong.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <livewire:admin.product.product-create/>

</div>
