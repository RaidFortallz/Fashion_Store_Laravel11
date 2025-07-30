<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Shop\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latestProducts = Product::where('status', Product::ACTIVE)
                                 ->latest()
                                 ->take(8)
                                 ->get();
        
        $discountedProducts = Product::where('status', Product::ACTIVE)
                                  ->whereNotNull('sale_price')
                                  ->whereColumn('sale_price', '<', 'price')
                                  ->orderBy('updated_at', 'desc')
                                  ->inRandomOrder() 
                                  ->take(4)
                                  ->get();

        return view('themes.jawique.home', [
            'popularProducts' => $discountedProducts,
            'latestProducts' => $latestProducts,
        ]);
    }
}
