<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\AddressFactory;

use App\Traits\UuidTrait;

/**
 * Modules\Shop\App\Models\Address
 *
 * @property string $id
 * @property string $user_id
 * @property bool $is_primary
 * @property string $first_name
 * @property string $last_name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $city
 * @property string|null $province
 * @property int|null $postcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @mixin \Eloquent
 */

class Address extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_addresses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
          'user_id',
          'first_name',
          'last_name',
          'address1',
          'address2',
          'phone',
          'email',
          'city',
          'province',
          'postcode',
          'is_primary',
    ];

     protected static function newFactory(): AddressFactory
     {
          return AddressFactory::new();
     }

     public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
