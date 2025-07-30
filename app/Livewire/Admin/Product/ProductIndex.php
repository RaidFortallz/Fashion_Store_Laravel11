<?php

namespace App\Livewire\Admin\Product;

use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Shop\Models\CartItem;
use Modules\Shop\Models\OrderItem;
use Modules\Shop\Models\Product;
use Modules\Shop\Models\ProductImage;

class ProductIndex extends Component
{
    public $perPage = 10;

    #[Url(as: 'q')]
    public ? string $search;
    public function render()
    {
        $products = Product::orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $products = $products->where('name', 'LIKE', '%' . $this->search . '%');
        }

        return view('livewire.admin.product.product-index', [
            'products' => $products->paginate($this->perPage),
        ]);
    }

    public function delete($id) {
        $product = Product::findOrFail($id);
        $product->categories()->detach();
        $product->tags()->detach();
        CartItem::where('product_id', $product->id)->delete();
        OrderItem::where('product_id', $product->id)->delete();
        $product->clearMediaCollection('products');
        ProductImage::where('product_id', $product->id)->delete();
        if ($product->inventory) {
            $product->inventory()->delete(); 
        }
        $product->favoritedByUsers()->detach();
        $product->delete();

        session()->flash('success', 'Produk dihapus!');
    }

    public function changePerPage($perPage) {
        if (($perPage < 5) || ($perPage > 25)) {
            $this->perPage = 5;
            return;
        }

        $this->perPage = $perPage;
    }
}
