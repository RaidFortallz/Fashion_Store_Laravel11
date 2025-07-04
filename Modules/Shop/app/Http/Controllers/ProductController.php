<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterfaces;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterfaces;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepositoryInterfaces $productRepository, CategoryRepositoryInterfaces $categoryRepository) {

        parent::__construct();

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;

        $this->data['categories'] = $this->categoryRepository->findAll();
        
    }

    public function index()
    {
        $options = [
            'per_page' => $this->perPage,
        ];
        
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
}
