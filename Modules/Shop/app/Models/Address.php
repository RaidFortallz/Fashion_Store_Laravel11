<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\AddressFactory;

use App\Traits\UuidTrait;

class Address extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_addresses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

     protected static function newFactory(): AddressFactory
     {
          return AddressFactory::new();
     }
}
