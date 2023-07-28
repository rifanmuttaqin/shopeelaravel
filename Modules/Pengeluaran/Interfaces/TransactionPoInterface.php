<?php

namespace Modules\Pengeluaran\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface TransactionPoInterface
{
    public function getAll($date_start=null, $date_end=null, $supplier=null);
    public function getTotalOutcomeByFilter($date_start=null, $date_end=null, $ori=null);
    public function TotalAmountByMonth($month=null,$year=null,$ori=null);
    public function findById($attribute);
    public function store(array $attribute);
    public function update(Model $model, array $attribute);
    public function destroy(Model $model);
    public function updateOrCreate(array $unique_attribute, array $target_attribute);
}