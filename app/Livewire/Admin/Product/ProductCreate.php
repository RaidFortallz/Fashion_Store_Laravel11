<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Shop\Models\Product;
use Modules\Shop\Models\Category;

class ProductCreate extends Component
{
    public $sku, $name, $type, $category_id;
    public $categories = [];

    public function mount()
    {
        // ✅ Ambil semua kategori untuk dropdown
        $this->categories = Category::all();
    }

    // ✅ Tidak perlu lagi Rule unique untuk SKU karena sudah dihandle di Model
    protected function rules()
    {
        return [
            'sku'  => ['nullable', 'string'], 
            'name' => ['required', 'string'],
            'type' => ['required', 'string'],
            'category_id' => ['required', 'exists:shop_categories,id']
        ];
    }

    public function save()
    {
        $user = Auth::user();
        $params = $this->validate();

        // Tambahkan field tambahan yang dibutuhkan
        $params['user_id'] = $user->id;
        $params['slug'] = Str::slug($params['name']);
        $params['status'] = Product::INACTIVE;

        // ✅ SKU akan dibuat otomatis unik oleh boot() di model Product
        $product = Product::create($params);

        // ✅ Attach ke kategori
        $product->categories()->attach($this->category_id);

        session()->flash('success', 'Produk berhasil dibuat.');
        $this->reset(['sku', 'name', 'type', 'category_id']);
        $this->dispatch('close-product-modal');

        // Redirect ke halaman update jika diperlukan
        $this->redirectRoute('admin.products.update', ['id' => $product->id]);
    }

    public function render()
    {
        return view('livewire.admin.product.product-create', [
            'categories' => $this->categories
        ]);
    }

    public function close()
    {
        $this->reset(['sku', 'name', 'type', 'category_id']);
    }
}
