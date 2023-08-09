<?php

namespace Modules\Pemasukan\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface OfflineTransactionInterface
{
    public function findById($attribute);
    public function store(array $attribute);
    public function update(Model $model, array $attribute);
    public function destroy(Model $model);
    public function updateOrCreate(array $unique_attribute, array $target_attribute);
    public function getAll($date_start=null, $date_end=null, $search = null, $customer_name=null, $status_transaksi=null);
    public function getTotalByMonthYear($ori=null);
    public function getTotalIncomeByFilter($date_start=null, $date_end=null, $ori=null);
    public function generateInvoiceCode();
    public function getTotalByDate($date);
    public function getCompareTransaction();
}