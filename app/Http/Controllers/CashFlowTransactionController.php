<?php

namespace App\Http\Controllers;

use App\Interfaces\CashFlowTransactionInterface;
use App\Model\CashFlow\CashFlowTransaction;
use Illuminate\Http\Request;

class CashFlowTransactionController extends Controller
{   
    public $cash_flow_transaction;

    public function __construct(CashFlowTransactionInterface $interface)
    {
        $this->cash_flow_transaction = $interface;
    }

    /**
     * Show the application
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $cash_flow_transaction = $this->cash_flow_transaction->getAll();

            return datatables()->of($cash_flow_transaction)->addColumn('type', function($row){  
                    return $this->cash_flow_transaction->meaning($row->type); 
                })->addColumn('action', function ($cash_flow_transaction) {
                return view('cashflow-transaction.action', [
                    'cash_flow' => $cash_flow_transaction
                ]);
            })->make(true);
        }

        return view('cashflow-transaction.index', ['active'=>'cashflow-transaction', 'title'=>'Input Data Neraca']);   
    }


}
