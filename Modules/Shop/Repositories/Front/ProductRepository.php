<?php 

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Models\Category;
use Modules\Shop\Models\Product;
use Modules\Shop\Models\Tag;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterfaces;

class ProductRepository implements ProductRepositoryInterfaces {
    
    public function findAll($options = []) {
        $perPage = $options['per_page'] ?? null;

        $categorySlug = $options['filter']['category'] ?? null;
        
        $tagSlug = $options['filter']['tag'] ?? null;

        $priceFilter = $options['filter']['price'] ?? null;

        $sort = $options['sort'] ?? null;

        $products = Product::with(['categories', 'tags']);


        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();

            $childCategoryIDs = Category::childIDs($category->id);

            $categoryIDs = array_merge([$category->id], $childCategoryIDs);

            $products = $products->whereHas('categories', function ($query) use ($categoryIDs) {
                $query->whereIn('shop_categories.id', $categoryIDs);
            });
        }

        if ($tagSlug) {
            $tag = Tag::where('slug', $tagSlug)->firstOrFail();

            $products = $products->whereHas('tags', function ($query) use ($tag) {
                $query->where('shop_tags.id', $tag->id);
            });
        }

        if ($priceFilter) {
            $products = $products->where('price', '>=', $priceFilter['min'])
            ->where('price', '<=', $priceFilter['max']);
        }

        if ($sort) {
            $products = $products->orderBy($sort['sort'], $sort['order']);
        }

        if ($perPage) {
            return $products->paginate($perPage);
        }

        return $products->get();
    }

    public function findBySKU($sku) {
        return Product::where('sku', $sku)->firstOrFail();
    }
}
