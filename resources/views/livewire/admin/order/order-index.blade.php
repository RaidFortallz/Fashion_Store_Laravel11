<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pesanan
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pesanan</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex mb-5">
                                <div class="ms-auto text-muted">
                                    Cari:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" wire:model.live="search" class="form-control form-control-sm" aria-label="Search">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="table-responsive"> -->
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">Pesanan</th>
                                        <th>Customer</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td class="align-text-top">
                                            <span>{{ $order->code }}</span><br />
                                            <span class="fw-bold">{{ $order->order_date_formatted }}</span><br />
                                        </td>
                                        <td class="align-text-top">
                                            <span class="fw-bold">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</span><br />
                                            <span>{{ $order->shipping_courier }} - {{ $order->shipping_service_name }}</span>
                                        </td>
                                        <td class="align-text-top">
                                            <ul style="margin-left:-15px">
                                                @foreach ($order->items as $item)
                                                <li>{{ Str::words($item->name, 3) }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="align-text-top">
                                            <span class="fw-bold">{{ number_format($order->grand_total) }}</span><br />
                                            <span>{{ $order->payment_method }}</span>
                                        </td>
                                        <td class="align-text-top"><span class="badge badge-outline {{ $order->status_badge }}">{{ $order->status }}</span></td>
                                        <td class="text-end align-text-top">
                                            <a wire:navigate href="{{ route('admin.orders.show', [$order->id]) }}" class="btn btn-outline-primary btn-sm btn-pill w-20">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- </div> -->
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>