<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

use App\Models\User;
use Modules\Shop\Models\Cart;
use Modules\Shop\Models\CartItem;
use Modules\Shop\Models\Product;

interface CartRepositoryInterfaces {
    public function findByUser(User $user): Cart;
    public function addItem(Product $product, $qty): CartItem;
    public function removeItem($id): bool;
    public function updateQty($items = []): void;
}