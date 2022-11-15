<?php

namespace App\Http\Modules\Bases;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository
{
    protected $model;

    function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        return  $this->model->find($id);
    }

    public function save(Model $model)
    {
        $model->save();
        return $model;
    }

    public function update(Model $model, Request $data)
    {
        $model->update($data->all());
        return $model;
    }

    public function delete(Model $model)
    {
        $model->delete();
        return $model;
    }
}
