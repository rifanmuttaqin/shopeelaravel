<?php

namespace App\Repository;

use App\Interfaces\CashFlowComponentInterface;
use App\Model\CashFlow\CashFlowComponent;

use function PHPUnit\Framework\returnSelf;

class CashFlowComponentRepository implements CashFlowComponentInterface
{
    private $model;

    public function __construct(CashFlowComponent $cashflow)
    {
        $this->model   = $cashflow;
    }

    public function getAll($search=null)
    {
        return $this->model->where('category_name', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function meaning($param)
    {
        switch ($param) {
            case CashFlowComponent::RECEIPT;
                return CashFlowComponent::RECEIPT_STRING; 
            case CashFlowComponent::SPENDING;
                return CashFlowComponent::SPENDING_STRING;            
            default:
                return 'Not available';        }
    }

}