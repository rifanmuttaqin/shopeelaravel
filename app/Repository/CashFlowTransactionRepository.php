<?php

namespace App\Repository;

use App\Interfaces\CashFlowTransactionInterface;
use App\Model\CashFlow\CashFlowTransaction;

class CashFlowTransactionRepository implements CashFlowTransactionInterface
{
    private $model;

    public function __construct(CashFlowTransaction $cashflow)
    {
        $this->model   = $cashflow;
    }

    public function getAll($search=null)
    {
        return $this->model->orderBy('created_at', 'DESC');
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
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