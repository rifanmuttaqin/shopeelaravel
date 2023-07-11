<?php

namespace Modules\Pengeluaran\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface TransaksiPoInterface
{
    public function findById($attribute);
    public function store(array $attribute);
    public function update(Model $model, array $attribute);
    public function destroy(Model $model);
    public function updateOrCreate(array $unique_attribute, array $target_attribute);
}