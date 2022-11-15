<?php

namespace App\Http\Modules\Categories\Repositories;

use App\Http\Modules\Bases\BaseRepository;
use App\Http\Modules\Categories\Models\Category;
use Termwind\Components\Dd;

class CategoryRepository extends BaseRepository
{
    protected $model;

    function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }

    /**
     * Function to get all Categories with pagination
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @param int $limit
     * @param int $search
     */
    public function paginate(int $limit, string $search, string $active)
    {

        return $this->model->select('id', 'name', 'description', 'is_active', 'type')
            ->when($active, function ($query) use ($active) {
                if ($active === "active") {
                    $query->where('is_active', 1);
                } elseif ($active === "inactive") {
                    $query->where('is_active', 0);
                }
            })
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->paginate($limit);
    }
}
