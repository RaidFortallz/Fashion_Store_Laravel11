<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterfaces;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterfaces;
use Modules\Shop\Repositories\Front\Interfaces\TagRepositoryInterfaces;

class ProductController extends Controller 
{
    protected $productRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $defaultPriceRange;
    protected $sortingQuery;

    public function __construct(ProductRepositoryInterfaces $productRepository,
     CategoryRepositoryInterfaces $categoryRepository, TagRepositoryInterfaces $tagRepository) {

        parent::__construct();

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->defaultPriceRange = [
            'min' => 10000,
            'max' => '100000',
        ];

        $this->data['categories'] = $this->categoryRepository->findAll();
        $this->data['filter']['price'] = $this->defaultPriceRange;

        $this->sortingQuery = null;
        $this->data['sortingQuery'] = $this->sortingQuery;
        $this->data['sortingOptions'] = [
            '' => '-- Urutkan Produk --',
            '?sort=price&order=asc' => 'Harga: Bawah ke Atas',
            '?sort=price&order=desc' => 'Harga: Atas ke Bawah',
            '?sort=publish_date&order=desc' => 'Produk terbaru',
        ];
        
    }

    public function index(Request $request)
    {
        $priceFilter = $this->getPriceFilter($request); 

        $options = [
            'per_page' => $this->perPage, 
            'filter' => [
                'price' => $priceFilter,
            ],
        ];

        if ($request->get('price')) {
            $this->data['filter']['price'] = $priceFilter;
        }

        if ($request->get('sort')) {
            $sort = $this->sortingRequest($request);
            $options['sort'] = $sort;

            $this->sortingQuery = '?sort=' . $sort['sort'] . '&order=' . $sort['order'];
            $this->data['sortingQuery'] = $this->sortingQuery;
        }
        
        $this->data['products'] = $this->productRepository->findAll($options);
        
        return $this->loadTheme('products.index', $this->data);
    }

    public function category($categorySlug) {

        $category = $this->categoryRepository->findBySlug($categorySlug);

        $options = [
            'per_page' => $this->perPage,
            'filter' => [
                'category' => $categorySlug,
            ]
        ];

        $this->data['products'] = $this->productRepository->findAll($options);
        $this->data['category'] = $category;

        return $this->loadTheme('products.category', $this->data);
    }

    public function tag($tagSlug) {
        $tag = $this->tagRepository->findBySlug($tagSlug);
        
        $options = [
            'per_page' => $this->perPage,
            'filter' => [
                'tag' => $tagSlug,
            ]
        ];

        $this->data['products'] = $this->productRepository->findAll($options);
        $this->data['tag'] = $tag;

        return $this->loadTheme('products.tag', $this->data);
    }

    public function show($categorySlug, $productSlug) {
        $sku = Arr::last(explode('-', $productSlug));
        
        $product = $this->productRepository->findBySKU($sku);
        

        $this->data['product'] = $product;

        return $this->loadTheme('products.show', $this->data);
    }

    function getPriceFilter($request) {
        if (!$request->get('price')) {
            return [];
        }

        $prices = explode(' - ', $request->get('price'));

        if (count($prices) < 0) {
            return $this->defaultPriceRange;
        }

        return [
            'min' => (int) $prices[0],
            'max' => (int) $prices[1],
        ];
    }

    function sortingRequest(Request $request) {
        $sort = [];

        if ($request->get('sort') && $request->get('order')) {
            $sort = [
                'sort' => $request->get('sort'),
                'order' => $request->get('order'),
            ];
        } else if ($request->get('sort')) {
            $sort = [
                'sort' => $request->get('sort'),
                'order' => 'desc',
            ];
        }

        return $sort;
    }
    
}
