<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\ProductFactory;
use App\Traits\UuidTrait;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, UuidTrait;

    protected $fillable = [
        'parent_id',
        'user_id',
        'sku',
        'type',
        'name',
        'slug',
        'price',
        'featured_image',
        'sale_price',
        'status',
        'stock_status',
        'manage_stock',
        'publish_date',
        'excerpt',
        'body',
        'metas',
        'weight',
    ];

    protected $table = 'shop_products';

    public const DRAFT = 'DRAFT';
    public const ACTIVE = 'ACTIVE';
    public const INACTIVE = 'INACTIVE';

    public const STATUSES = [
        self::DRAFT => 'Draft',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    public const STATUS_IN_STOCK = 'IN_STOCK';
    public const STATUS_OUT_OF_STOCK = 'OUT_OF_STOCK';

    public const STOCK_STATUSES = [
        self::STATUS_IN_STOCK => 'Tersedia',
        self::STATUS_OUT_OF_STOCK => 'Tidak Tersedia',
    ];

    public const SIMPLE = 'SIMPLE';
    public const CONFIGURABLE = 'CONFIGURABLE';
    public const TYPES = [
        self::SIMPLE => 'Simple',
        self::CONFIGURABLE => 'Configurable',
    ];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(6));
            }
            
            while (self::where('sku', $product->sku)->exists()) {
                $product->sku = 'SKU-' . strtoupper(Str::random(6));
            }
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(150)
              ->height(150)
              ->sharpen(10);
    }

    // 🔹 Relasi
    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function inventory() {
        return $this->hasOne(ProductInventory::class);
    }

    public function variants() {
        return $this->hasMany(Product::class, 'parent_id')->orderBy('price', 'ASC');
    }

    public function categories() {
        return $this->belongsToMany(Category::class,
            'shop_categories_products',
            'product_id',
            'category_id',
        );
    }

    public function tags() {
        return $this->belongsToMany(Tag::class,
            'shop_products_tags',
            'product_id',
            'tag_id',
        );
    }

    public function attributes() {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function image() {
        return $this->hasOne(ProductImage::class)->where('id', $this->featured_image);
    }

    // 🔹 Accessor
    public function getPriceLabelAttribute() {
        return number_format($this->price, 0, ',', '.');
    }

    public function getHasSalePriceAttribute() {
        return $this->sale_price != null;
    }

    public function getSalePriceLabelAttribute() {
        return number_format($this->sale_price, 0, ',', '.');
    }

    public function getDiscountPercentAttribute() {
        $discount_percent = (($this->price - $this->sale_price) / $this->price * 100);
        return number_format($discount_percent);
    }

    public function getStockStatusLabelAttribute() {
        return self::STOCK_STATUSES[$this->stock_status];
    }

    public function getStockAttribute() {
        return $this->inventory ? $this->inventory->qty : 0;
    }
}
