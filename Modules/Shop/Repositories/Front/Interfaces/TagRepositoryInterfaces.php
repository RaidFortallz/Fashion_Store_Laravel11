<?php

namespace Modules\Shop\Repositories\Front\Interfaces;

interface TagRepositoryInterfaces {
    public function findAll($options = []);
    public function findBySlug($slug);
}