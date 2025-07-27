<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\ProductImageFactory;
use App\Traits\UuidTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductImage extends Model implements HasMedia
{
    use HasFactory, UuidTrait, InteractsWithMedia;

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

     public function registerMediaConversions(?Media $media = null): void
     {
        $this->addMediaConversion('img-thumb')->width(150)->height(150);
        $this->addMediaConversion('img-medium')->width(280)->height(400);
        $this->addMediaConversion('img-large')->width(675)->height(1024);
     }
}
