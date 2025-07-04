<?php

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Models\Tag;
use Modules\Shop\Repositories\Front\Interfaces\TagRepositoryInterfaces;

class TagRepository implements TagRepositoryInterfaces {

    public function findAll($options = []) {
        return Tag::orderBy('name', 'asc')->get();
    }

    public function findBySlug($slug) {
        return Tag::where('slug', $slug)->firstOrFail();
    }
}