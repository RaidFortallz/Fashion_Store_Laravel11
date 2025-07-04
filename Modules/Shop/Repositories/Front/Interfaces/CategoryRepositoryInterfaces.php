<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

interface CategoryRepositoryInterfaces {
    public function findAll($options = []);
    public function findBySlug($slug);
}