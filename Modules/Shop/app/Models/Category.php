<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\CategoryFactory;
use App\Traits\UuidTrait;
use Modules\Shop\Models\Product;

class Category extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_categories';

    protected $fillable = [
        'parent_id',
        'slug',
        'name',
    ];

    /**
     * Factory
     */
    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    /**
     * Relasi: kategori memiliki banyak anak (subkategori)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relasi: kategori memiliki parent
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relasi: kategori dapat memiliki banyak produk
     * Pivot table: shop_categories_products
     */
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'shop_categories_products', // nama pivot table
            'category_id',              // FK kategori di pivot
            'product_id'                // FK produk di pivot
        );
    }

    /**
     * Rekursif: mendapatkan ID semua anak kategori dari parent tertentu
     */
    public static function childIDs($parentID = null)
    {
        $categories = Category::select('id', 'name', 'parent_id')
            ->where('parent_id', $parentID)
            ->get();

        $childIDs = [];

        if ($categories->isNotEmpty()) {
            foreach ($categories as $category) {
                $childIDs[] = $category->id;
                $childIDs = array_merge($childIDs, Category::childIDs($category->id));
            }
        }

        return $childIDs;
    }
}
