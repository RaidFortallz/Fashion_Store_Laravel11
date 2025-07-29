<?php

namespace App\Livewire\Admin\Order;

use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Shop\Models\Order;

class OrderIndex extends Component
{
    public $perPage = 5;

    #[Url(as: 'q')]
    public ? string $search;
    public function render()
    {
         $orders = Order::orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $orders = $orders->where('code', 'LIKE', '%' . $this->search . '%')
            ->orWhere('customer_first_name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('customer_last_name', 'LIKE', '%' . $this->search . '%');
        }

        return view('livewire.admin.order.order-index', [
            'orders' => $orders->paginate($this->perPage),
        ]);
    }
}
