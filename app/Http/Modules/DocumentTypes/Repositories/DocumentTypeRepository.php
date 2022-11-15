<?php

namespace App\Http\Modules\DocumentTypes\Repositories;

use App\Http\Modules\Bases\BaseRepository;
use App\Http\Modules\DocumentTypes\Models\DocumentType;
use Illuminate\Database\Eloquent\Collection;

class DocumentTypeRepository extends BaseRepository
{
    protected $model;
    function __construct(DocumentType $DocumentType)
    {
        parent::__construct($DocumentType);
        $this->model = $DocumentType;
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
