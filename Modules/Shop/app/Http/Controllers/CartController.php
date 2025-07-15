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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $productID = $request->get('product_id');
        $qty = $request->get('qty');

        $product = $this->productRepository->findByID($productID);
        
        if ($product->stock_status != Product::STATUS_IN_STOCK) {
            return redirect(shop_product_link($product))->with('error', 'Stok produk ini tidak tersedia');
        }
        
        if ($product->stock < $qty) {
            return redirect(shop_product_link($product))->with('error', 'Stok produk tidak cukup');
        }

        $item = $this->cartRepository->addItem($product, $qty);
        if (!$item) {
            return redirect(shop_product_link($product))->with('error', 'Tidak dapat menambahkan ke keranjang');
        }

        return redirect(shop_product_link($product))->with('success', 'Berhasil menambahkan ke keranjang');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('shop::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('shop::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        $items = $request->get('qty');
        $this->cartRepository->updateQty($items);

        return redirect(route('carts.index'))->with('success', 'Keranjang diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $this->cartRepository->removeItem($id);

        return redirect(route('carts.index'))->with('success', 'Berhasil hapus pesanan');
    }
}
