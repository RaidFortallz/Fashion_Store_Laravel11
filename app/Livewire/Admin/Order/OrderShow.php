<?php

namespace App\Livewire\Admin\Order;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shop\Models\Order;

class OrderShow extends Component
{
    public $id;

    #[On('order-progress-updated')]
    #[On('order-cancelled')]

    public function render()
    {
        $order = Order::findOrFail($this->id);

        $canUpdateProgress = true;
        if (in_array($order->status, [Order::STATUS_CANCELLED, Order::STATUS_DELIVERED, Order::STATUS_RECEIVED])) {
            $canUpdateProgress = false;
        }

        return view('livewire.admin.order.order-show', [
            'order' => $order,
            'canUpdateProgress' => $canUpdateProgress,
        ]);
    }
}
