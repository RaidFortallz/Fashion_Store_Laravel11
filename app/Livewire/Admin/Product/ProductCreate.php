<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Shop\Models\Product;

class ProductCreate extends Component
{
    public $sku, $name, $type;

    protected function rules() {
        return [
            'sku' => [
                'required',
                'string',
                Rule::unique('shop_products', 'sku'),
            ],
            'name' => [
                'required',
                'string',
            ],
            'type' => [
                'required',
                'string',
            ]
        ];
    }

    public function render()
    {
        return view('livewire.admin.product.product-create');
    }

    public function save() {
        $user = Auth::user();
        $params = $this->validate();
        $params['user_id'] = $user->id;
        $params['slug'] = Str::slug($params['name']);
        $params['status'] = Product::INACTIVE;

        if ($product = Product::create($params)) {
            session()->flash('success', 'Produk dibuat.');
            $this->reset();
            $this->redirectRoute('admin.products.update', ['id' => $product->id]);
            return;
        }

        session()->flash('error', 'Gagal');
    }

    public function close() {
        $this->reset();
    }
}
