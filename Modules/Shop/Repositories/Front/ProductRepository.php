<?php 

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Models\Product;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterfaces;

class ProductRepository implements ProductRepositoryInterfaces {
    
    public function findAll($options = []) {
        $perPage = $options['per_page'] ?? null;
        $product = Product::with(['categories', 'tags']);

        if ($perPage) {
            return $product->paginate($perPage);
        }

        return $product->get();
    }
}
