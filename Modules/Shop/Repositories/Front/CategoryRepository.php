<?php

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Models\Category;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterfaces;

class CategoryRepository implements CategoryRepositoryInterfaces {

    public function findAll($options = []) {
        return Category::orderBy('name', 'asc')->get();
    }

    public function findBySlug($slug) {
        return Category::where('slug', $slug)->firstOrFail();
    }
}