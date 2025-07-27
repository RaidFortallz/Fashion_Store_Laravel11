<div x-data @close-product-modal.window="$('#modal-product-create').modal('hide')">
    <div wire:ignore.self class="modal fade" id="modal-product-create" tabindex="-1" aria-labelledby="modalProductCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductCreateLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="close"></button>
                </div>

                <div class="modal-body">
                    {{-- SKU --}}
                    <div class="mb-3">
                        <label>SKU</label>
                        <input wire:model="sku" type="text" class="form-control @error('sku') is-invalid @enderror">
                        @error('sku')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    {{-- Nama Produk --}}
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    {{-- Tipe Produk --}}
                    <div class="mb-3">
                        <label>Tipe Produk</label>
                        <input wire:model="type" type="text" class="form-control @error('type') is-invalid @enderror" placeholder="contoh: aksesoris">
                        @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select wire:model="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Simpan</button>
                </div>

            </div>
        </div>
    </div>
</div>
