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
    /**
     * Show the about us page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        $team = [
            [
                'name' => 'Ageng Eko',
                'role' => 'Midlaner',
                'instagram' => 'pangeran_ageng',
                'whatsapp' => '6285324712351', 
                'image' => asset('images/foto_eko.jpg')
            ],
            [
                'name' => 'Hikam Sirrul Arifin',
                'role' => 'Explaner',
                'instagram' => 'hikamsrl',
                'whatsapp' => '628882370643',
                'image' => asset('images/foto_hikam.jpg')
            ],
            [
                'name' => 'Muhammad Dimas Daniswara',
                'role' => 'Roamer',
                'instagram' => 'm.dimsssdpp',
                'whatsapp' => '6281927310145', 
                'image' => asset('images/foto_dimas.png')
            ],
            [
                'name' => 'Naufal Pratista Sugandhi',
                'role' => 'Jungler',
                'instagram' => 'naufalpratistas',
                'whatsapp' => '6289513149721', 
                'image' => asset('images/foto_naufal.jpg')
            ],
        ];

        return view('themes.jawique.about.about', ['team' => $team]);
    }
}

