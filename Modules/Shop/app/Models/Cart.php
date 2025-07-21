<?php

namespace Modules\Shop\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Cart
 *
 * @property string $id
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon $expired_at
 * @property string $base_total_price
 * @property string $tax_amount
 * @property string $tax_percent
 * @property string $discount_amount
 * @property string $discount_percent
 * @property string $grand_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Query\Builder|Cart onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cart withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cart withoutTrashed()
 *
 * @mixin \Eloquent
 */


class Cart extends Model
{
    use UuidTrait, SoftDeletes;

    protected $table = 'shop_carts';
    protected $fillable = [
        'user_id',
        'expired_at',
        'base_total_price',
        'discount_amount',
        'discount_percent',
        'tax_percent',
        'tax_amount',
        'grand_total',
        'total_weight',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(CartItem::class);
    }

    public function scopeForUser(Builder $query, User $user): void {
        $query->where('user_id', $user->id);
    }

    public function getGrandTotalLabelAttribute() {
        return number_format($this->grand_total, 0, ',', '.');
    }

    public function getDiscountAmountLabelAttribute() {
        return number_format($this->discount_amount, 0, ',', '.');
    }

    public function getTaxAmountLabelAttribute() {
        return number_format($this->tax_amount, 0, ',', '.');
    }

    public function getBaseTotalPriceLabelAttribute() {
        return number_format($this->base_total_price, 0, ',', '.');
    }

    public function getSubTotalPriceLabelAttribute() {
        return number_format($this->base_total_price - $this->discount_amount, 0, ',', '.');
    }
}
