<?php

namespace App\Repository;

use App\Interfaces\CashFlowTransactionInterface;
use App\Model\CashFlow\CashFlowTransaction;
use Carbon\Carbon;

class CashFlowTransactionRepository implements CashFlowTransactionInterface
{
    private $model;

    public function __construct(CashFlowTransaction $cashflow)
    {
        $this->model   = $cashflow;
    }

    public function getAll($search=null)
    {
        return $this->model->with('cashFlow')->when(request()->search, function ($query) {
            if (!is_array(request()->search)) {
                $query->whereRelation('cashFlow', 'category_name', '%','LIKE','%' . request()->search . '%');
            }
        })->orderBy('created_at', 'DESC');
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function countIncome($date_start=null, $date_end=null)
    {
        return $this->countAmountOfCashflow(CashFlowTransaction::RECEIPT, $date_start, $date_end);

    }

    public function countOutcome($date_start=null, $date_end=null)
    {
       return $this->countAmountOfCashflow(CashFlowTransaction::SPENDING, $date_start, $date_end);
    }


    private function countAmountOfCashflow($type, $date_start=null, $date_end=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        return $this->model
        ->whereBetween('date', [$date_from, $date_to])
        ->where('type', $type)
        ->sum('amount');
    }


    public function meaning($param)
    {
        switch ($param) {
            case CashFlowTransaction::RECEIPT;
                return CashFlowTransaction::RECEIPT_STRING;
            case CashFlowTransaction::SPENDING;
                return CashFlowTransaction::SPENDING_STRING;
            default:
                return 'Not available';        }
    }

}
