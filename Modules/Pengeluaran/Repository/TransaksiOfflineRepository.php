<?php

namespace Modules\Pengeluaran\Repository;

use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;
use Modules\Pengeluaran\Interfaces\TransaksiPoInterface;


class TransaksiPoRepository implements TransaksiPoInterface
{
    protected $model;

    public function __construct(TransaksiPo $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }

    public function update($model, $data)
    {
        return $this->findById($model->id)->update($data);
    }

    public function updateOrCreate(array $unique_attribute, array $target_attribute)
    {
        return $this->model->updateOrCreate($unique_attribute,$target_attribute);
    }

}
