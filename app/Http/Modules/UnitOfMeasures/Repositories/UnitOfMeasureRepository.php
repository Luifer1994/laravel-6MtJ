<?php

namespace App\Http\Modules\UnitOfMeasures\Repositories;

use App\Http\Modules\Bases\BaseRepository;
use App\Http\Modules\UnitOfMeasures\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Collection;

class UnitOfMeasureRepository extends BaseRepository
{
    protected $model;
    function __construct(UnitOfMeasure $UnitOfMeasure)
    {
        parent::__construct($UnitOfMeasure);
        $this->model = $UnitOfMeasure;
    }

    /**
     * Funtion to get all document types.
     *
     * @return collection
     */
    public function getAll()
    {
        return $this->model->select('id', 'name', 'code', 'is_active')->get();
    }

    /**
     * Funtion to get all document types actives.
     *
     * @return collection
     */
    public function getAllActives()
    {
        return $this->model->select('id', 'name', 'code', 'is_active')->where('is_active', true)->get();
    }
}
