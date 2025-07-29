<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Models\Product;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterfaces;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterfaces;

class CartController extends Controller
{
    protected $cartRepository;
    protected $productRepository;

    public function __construct(CartRepositoryInterfaces $cartRepository, ProductRepositoryInterfaces $productRepository) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $cart = $this->cartRepository->findByUser($user);
        
        $this->data['cart'] = $cart;

        return $this->loadTheme('carts.index', $this->data);
    }

    public function store(Request $request) {
        $productID = $request->get('product_id');
        $qty = $request->get('qty', 1);

        $product = $this->productRepository->findByID($productID);
        
        if ($product->stock_status != Product::STATUS_IN_STOCK) {
            return redirect()->back()->with('error', 'Stok produk ini tidak tersedia');
        }
        
        if ($product->stock < $qty) {
            return redirect()->back()->with('error', 'Stok produk tidak cukup');
        }

        $item = $this->cartRepository->addItem($product, $qty);
        if (!$item) {
            return redirect()->back()->with('error', 'Tidak dapat menambahkan ke keranjang');
        }

        // PERBAIKAN: Menggunakan redirect()->back() untuk kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Berhasil menambahkan ke keranjang');
    }

    public function update(Request $request) {
        $items = $request->get('qty');
        $this->cartRepository->updateQty($items);

        return redirect(route('carts.index'))->with('success', 'Keranjang diperbarui');
    }

    public function destroy($id) {
        $this->cartRepository->removeItem($id);

        return redirect(route('carts.index'))->with('success', 'Berhasil hapus pesanan');
    }
}
