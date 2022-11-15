<?php

namespace App\Http\Modules\Categories\Services;

use App\Http\Modules\Categories\Repositories\CategoryRepository;

class CategoryService
{
    protected   $CategoryRepository;

    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }
}
