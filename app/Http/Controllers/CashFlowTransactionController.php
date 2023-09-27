<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashFlow\CashFlowTransactionRequest;
use App\Interfaces\CashFlowComponentInterface;
use App\Interfaces\CashFlowTransactionInterface;
use App\Model\CashFlow\CashFlowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashFlowTransactionController extends Controller
{   
    public $cash_flow_transaction;
    public $cash_flow_component;

    public function __construct(CashFlowTransactionInterface $cash_flow_transaction, CashFlowComponentInterface $cash_flow_component)
    {
        $this->cash_flow_transaction = $cash_flow_transaction;
        $this->cash_flow_component = $cash_flow_component;
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


    public function store(CashFlowTransactionRequest $request)
    {
        if($request->ajax())
        {
            DB::beginTransaction();
            
            $cash_flow_data =  $this->cash_flow_component->findById($request->cash_flow_camponent_id);
            
            if($cash_flow_data != null)
            {
                try {
                    CashFlowTransaction::create(array_merge(['type' => $cash_flow_data->type],$request->all()));
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                }
    
                return $this->getResponse(true,200,null,'Sucsess');
            }

            return $this->getResponse(false,400,null,'Error');
        }
    }

}
