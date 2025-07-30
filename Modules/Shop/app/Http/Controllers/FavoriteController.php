<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Models\Product;

class FavoriteController extends Controller
{
    public function toggle(Product $product) {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
        } else {
            $user->favorites()->attach($product->id);
        }

        return back()->with('success', 'Produk telah diperbarui di favorit.');
    }
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->latest()->get();
        return view('themes.jawique.products.favorites', compact('favorites'));
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
    public function store(Request $request) {}

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
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
