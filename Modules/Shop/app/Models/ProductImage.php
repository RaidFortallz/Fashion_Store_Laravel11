<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\ProductImageFactory;
use App\Traits\UuidTrait;

class ProductImage extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_product_images';

    protected $fillable = [
        'product_id',
        'name',
    ];

    public const DEFAULT_IMAGE = 'https://placehold.jp/150x150.png';

    protected static function newFactory(): ProductImageFactory
    {
        return ProductImageFactory::new();
    }
}
