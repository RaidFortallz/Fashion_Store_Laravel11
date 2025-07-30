<?php

namespace App\Livewire\Admin\Order;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shop\Models\Order;
use Modules\Shop\Models\ProductInventory;

class OrderUpdate extends Component
{
    public $action_note, $shipping_number;
    public $action_button_label = 'CONFIRM';
    public $order_status = '';
    public Order $order;
    public $nextActionType = '';
    public $nextAction= [];

    public function rules() {
        $rules = [
            'action_note' => 'nullable|string|max:255',
        ];

        if ($this->nextActionType === Order::ACTION_DELIVER) {
            $rules['shipping_number'] = 'required|string|max:255';
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.admin.order.order-update');
    }

    #[On('show-order-action')]
    public function findOrder($id) {
        $this->order = Order::findOrFail($id);
        $this->nextAction = $this->nextActionAndStatus($this->order->status);
        $this->action_button_label = $this->nextAction['action_label'];
        $this->order_status = $this->nextAction['status'];
        $this->nextActionType = $this->nextAction['action'];
        $this->shipping_number = $this->order->shipping_number ??  '';
    }

    public function close() {
        $this->reset();
    }

    public function cancel() {
        $this->reset();
    }

    public function update() {
        if (!$this->nextAction) {
            return redirect()->route('admin.orders.index')->with('error', 'Tidak ada proses yang bisa dilakukan pada order ini');
        }

        $params = $this->validate();
        $params['next_action'] = $this->nextAction;
        if ($this->updateProgress($this->order, $params)) {
            $this->dispatch('order-progress-updated');
            session()->flash('success', 'Proses pesanan berhasil diperbarui.');
            $this->reset();
            return;
        }

        session()->flash('error', 'Gagal memperbarui.');
    }

    private function updateProgress(Order $order, array $params) {
        DB::beginTransaction();

        try {
            $order->status= $params['next_action']['status'];
            if ($params['next_action']['action'] === Order::ACTION_DELIVER) {
                $order->shipping_number = $params['shipping_number'];
            }

            $order->save();

            if ($order->status == Order::STATUS_DELIVERED) {
                $this->confirmStockDeduction($order);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal memperbarui: ' . $e->getMessage());
            return false;
        }

        return true;
    }

    private function confirmStockDeduction($order) {
        if ($order->items->count() > 0) {
            foreach ($order->items as $item) {
                $inventory = ProductInventory::where('product_id', $item->product_id)->firstOrFail();
                $deductedQty = $item->qty;
                $stockAfter = $inventory->qty - $deductedQty;
                if ($stockAfter < 0) {
                    session()->flash('error', 'Stok tidak cukup untuk produk ' . $item->product->name);
                }
                $inventory->qty = $stockAfter;
                $inventory->save(); 
            }
        }
    }

    private function nextActionAndStatus($currentOrderStatus = Order::STATUS_PENDING) {
        switch ($currentOrderStatus) {
            case Order::STATUS_PENDING:
                return [
                 'action' => Order::ACTION_CONFIRM,
                 'action_label' => Order::ACTION_LABELS[Order::ACTION_CONFIRM],
                 'status' => Order::STATUS_CONFIRMED,
                ];
            case Order::STATUS_CONFIRMED:
                return [
                 'action' => Order::ACTION_PACKING,
                 'action_label' => Order::ACTION_LABELS[Order::ACTION_PACKING],
                 'status' => Order::STATUS_PACKAGING,
                ];
            case Order::STATUS_PACKAGING:
                return [
                 'action' => Order::ACTION_DELIVER,
                 'action_label' => Order::ACTION_LABELS[Order::ACTION_DELIVER],
                 'status' => Order::STATUS_DELIVERED,
                ];
            case Order::STATUS_DELIVERED:
                return [
                 'action' => Order::ACTION_CONFIRM_RECEIVED,
                 'action_label' => Order::ACTION_LABELS[Order::ACTION_CONFIRM_RECEIVED],
                 'status' => Order::STATUS_RECEIVED
                ];
                default:
                    abort(403, 'proses tidak diketahui');
                    break;
        }
    }

}
