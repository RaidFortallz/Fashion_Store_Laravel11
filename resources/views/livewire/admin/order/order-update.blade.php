<div wire:ignore.self class="modal modal-blur fade" id="modal-order-update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Pesanan: {{ $action_button_label }}</h5>
                <button wire:click="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Alert Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-warning">
                        <div class="alert-title">Whooops!</div>
                        Ada yang salah dengan input mu.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>    
                @endif

                {{-- Status Saat Ini --}}
                <div class="mb-3">
                    <label class="form-label">Status Selanjutnya:</label>
                    <input type="text" class="form-control" value="{{ $order_status }}" disabled />
                </div>

                {{-- Input Resi Pengiriman (hanya jika aksi pengiriman) --}}
                @if ($nextActionType === 'DELIVER')
                    <div class="mb-3">
                        <label class="form-label required">Resi Pengiriman</label>
                        <input wire:model="shipping_number" type="text" class="form-control" 
                               @if (!empty($shipping_number)) disabled @endif />
                        @error('shipping_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                {{-- Catatan --}}
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea wire:model="action_note" 
                              class="summernote form-control @error('action_note') is-invalid @enderror">
                    </textarea>
                    @error('action_note')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <a wire:click="close" href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Tutup
                </a>
                <button wire:click="cancel" type="button" class="btn btn-danger ms-auto">
                    Batalkan
                </button>
                <button wire:click="update" type="button" class="btn btn-primary">
                    {{ $action_button_label }}
                </button>
            </div>
        </div>
    </div>
</div>
