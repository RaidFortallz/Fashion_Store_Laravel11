<?php

namespace App\Livewire\Admin\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Shop\Models\Product;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterfaces;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductUpdate extends Component
{
    use WithFileUploads;
    public $id;
    public Product $product;
    public string $sku, $name, $excerpt, $body, $status;
    public bool $manage_stock;
    public float $price;
    public $sale_price = null;
    public int $qty, $low_stock_threshold;

    public $image;
    private $productRepository;

    public function boot(ProductRepositoryInterfaces $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function mount() {
        $this->product = $this->productRepository->findByID($this->id);

        $this->sku = $this->product->sku;
        $this->name = $this->product->name;
        $this->excerpt = (string) $this->product->excerpt;
        $this->body = (string) $this->product->body;
        $this->price = (float) $this->product->price;
        $this->sale_price = $this->product->sale_price;
        $this->status = $this->product->status;
        $this->manage_stock = $this->product->manage_stock;
        
        if ($this->product->manage_stock && $this->product->inventory) {
            $this->qty = $this->product->inventory->qty;
            $this->low_stock_threshold = $this->product->inventory->low_stock_threshold;
        }
    }

    protected function rules() {
        return [
            'sku' => [
                'required',
                'string',
                Rule::unique('shop_products', 'sku')->ignore($this->product->id),
            ],
            'name' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'sale_price' => [
                'nullable',
                'numeric',
                'gte:0',
            ],
            'excerpt' => [
                'string',
            ],
            'body' => [
                'string',
            ],
            'status' => [
                'required',
                'string',
            ],
            'qty' => [
                'numeric',
                'nullable',
                Rule::requiredIf($this->product->manage_stock),
            ],
            'low_stock_threshold' => [
                'numeric',
                'nullable',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.product.product-update', [
            'product' => $this->product,
        ]);
    }

    public function update() {
        $params = $this->validate();

        if (!$this->product->weight) {
            $this->product->weight = 100;
        }
        
        $updated = DB::transaction(function () use ($params) {
            $params['sale_price'] = ($this->sale_price !== null && $this->sale_price !== '')
            ? floatval($this->sale_price)
            : null;

            $this->product->update($params);
            $this->updateStock($params);
            return true;
        });

        if ($updated) {
            session()->flash('success', 'Produk diperbarui');
            return;
        }

        session()->flash('error', 'Gagal!');
    }

    public function changeManageStock() {
        if ($this->product->manage_stock) {
            $this->product->manage_stock = false;
            $this->product->save();
            return;
        }

        $this->product->manage_stock = true;
        $this->product->save();
    }

    private function updateStock($params) {
        if (!$this->product->manage_stock) {
            return;
        }

        if ($this->product->inventory) {
            $this->product->inventory->update([
                'qty' => $params['qty'],
                'low_stock_threshold' => $params['low_stock_threshold'],
            ]);

            return;
        }

        $this->product->inventory()->create([
            'qty' => $params['qty'],
            'low_stock_threshold' => $params['low_stock_threshold'],
        ]);
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096', 'min:50']
        ]);

        $this->product->addMedia($this->image->getRealPath())
                      ->toMediaCollection('products');

        $this->product = $this->product->fresh();
        $this->product->load('media');
        
        $this->image = null;

        session()->flash('success', 'Gambar berhasil ditambahkan!');
    }

    public function deleteImage($mediaId) 
    {
        $media = Media::find($mediaId);

        if ($media) {
            $media->delete();
        }

        $this->product = $this->product->fresh();

        session()->flash('success', 'Foto berhasil dihapus');
    }

    public function setFeaturedImage($id) {
        $this->product->featured_image = $id;
        $this->product->save();
        $this->product = $this->product->fresh();

        session()->flash('success', 'Foto diperbarui');
    }
}
