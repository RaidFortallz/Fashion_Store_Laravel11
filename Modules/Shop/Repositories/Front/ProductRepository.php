<?php 

namespace Modules\Shop\Repositories\Front;

use Illuminate\Database\Eloquent\Collection;
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

        $search = $options['filter']['search'] ?? null;

        $products = Product::with(['categories', 'tags']);

        if ($search) {
            $products = $products->where('name', 'LIKE', '%' . $search . '%');
        }


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

    public function findByID($id) {
        return Product::where('id', $id)->firstOrFail();
    }
    
    public function findDiscountedProducts($limit = 8) : Collection
    {
        return Product::where('status', Product::ACTIVE) // Pastikan produk aktif
                        ->whereNotNull('sale_price') // Pastikan ada sale_price
                        ->whereColumn('sale_price', '<', 'price') // Pastikan sale_price lebih kecil dari price (ada diskon)
                        ->orderBy('sale_price', 'asc') // Urutkan dari harga diskon termurah
                        // Atau orderByRaw('((price - sale_price) / price) DESC') untuk diskon persentase terbesar
                        ->with(['categories', 'tags']) // Muat relasi jika dibutuhkan di Blade
                        ->take($limit)
                        ->get();
    }
}
