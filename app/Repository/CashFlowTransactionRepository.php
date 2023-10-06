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

    public function countIncome()
    {
        return $this->countAmountOfCashflow(CashFlowTransaction::RECEIPT);

    }

    public function countOutcome()
    {
       return $this->countAmountOfCashflow(CashFlowTransaction::SPENDING);
    }


    private function countAmountOfCashflow($type)
    {
        return $this->model
        ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
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