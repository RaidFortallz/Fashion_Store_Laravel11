<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Detail Order
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/orders" wire:navigate class="btn btn-white">
                                Kembali
                            </a>
                        </span>
                        <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Order</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-transparent table-responsive">
                                <tr>
                                    <td>No Order</td>
                                    <td><span class="fw-bold">#{{ $order->code }}</span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td><span class="fw-bold">{{ $order->order_date_formatted }}</span></td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td><span class="fw-bold">{{ $order->payment_method }}</span></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <span class="badge badge-outline {{ $order->status_badge }}">{{ $order->status }}</span>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Catatan</td>
                                    <td><i>{{ $order->note }}</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pengiriman</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-transparent table-responsive">
                                <tr>
                                    <td>Nama</td>
                                    <td><span class="fw-bold">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</span></td>
                                </tr>
                                <tr>
                                    <td>No Handphone</td>
                                    <td><span class="fw-bold">{{ $order->customer_phone }}</span></td>
                                </tr>
                                <tr>
                                    <td>Alamat Detail</td>
                                    <td><span class="fw-bold">{{ $order->customer_address1 }}</span></td>
                                </tr>
                                <tr>
                                    <td>No Resi</td>
                                    <td><span class="fw-bold">{{ $order->shipping_number }}</span></td>
                                </tr>
                                <tr>
                                    <td>Kurir</td>
                                    <td><span class="fw-bold">{{ $order->shipping_courier }} ({{ $order->shipping_service_name }})</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Produk</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-transparent table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%"></th>
                                        <th>Produk</th>
                                        <th class="text-center" style="width: 1%">Quantity</th>
                                        <th class="text-end" style="width: 1%">Satuan</th>
                                        <th class="text-end" style="width: 10%">Jumlah</th>
                                    </tr>
                                </thead>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td class="text-center"><span class="avatar me-3" style="background-image: url({{ $item->product->getFirstMediaUrl('products', 'thumb') }})"></span></td>
                                    <td>
                                        <p class="strong mb-1">{{ $item->name }}</p>
                                        <div class="text-secondary">
                                            @if ($item->product->sale_price > 0)
                                            <span class="fw-bold">{{ number_format($item->product->sale_price) }}</span> <span><del>{{ number_format($item->product->price) }}</del></span>
                                            @else
                                            <span class="fw-bold">{{ number_format($item->product->price) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="text-end">{{ number_format($item->base_price) }} </td>
                                    <td class="text-end">{{ number_format($item->total) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="strong text-end">Sub Total</td>
                                    <td class="text-end">{{ number_format($order->total) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="fw-bold text-uppercase text-end">Total Pembayaran ({{ $order->payment_method }})</td>
                                    <td class="fw-bold text-end">{{ number_format($order->grand_total) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                            <span class="d-none d-sm-inline">
                                <a href="/admin/orders" wire:navigate class="btn btn-white">
                                    Kembali
                                </a>
                            </span>
                            
                            @if ($canUpdateProgress)
                            <button wire:click="$dispatchTo('admin.order.order-update', 'show-order-action', { id: '{{ $order->id }}' })" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-order-update">Proses Order</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.order.order-update />
</div>

<script>
    document.addEventListener('livewire:init', () => {
        var myModal = new bootstrap.Modal(document.getElementById('modal-order-update'))
        Livewire.on('order-progress-updated', (event) => {
            myModal.hide()
        });

        Livewire.on('order-cancelled', (event) =>{
            myModal.hide()
        });
    });
</script>