<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

use App\Models\User;
use Modules\Shop\Models\Address;
use Modules\Shop\Models\Cart;
use Modules\Shop\Models\Order;

interface OrderRepositoryInterfaces {
    public function create(User $user, Cart $cart, Address $address, $shipping = []) :Order;
}