<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

interface ProductRepositoryInterfaces {
    public function findAll($options = []);
    public function findBySKU($sku);
    public function findByID($id);
    public function findDiscountedProducts($limit = 8): EloquentCollection;
}

