<?php

namespace App\Http\Controllers;

use App\Interfaces\CashFlowComponentInterface;
use Illuminate\Http\Request;

class CashFlowComponentController extends Controller
{

    public $cash_flow_component;

    public function __construct(CashFlowComponentInterface $interface)
    {
        $this->cash_flow_component = $interface;
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
            $cash_flow_component = $this->cash_flow_component->getAll();

            return datatables()->of($cash_flow_component)->addColumn('action', function ($cash_flow_component) {
                return view('cashflow-component.action', [
                    'cash_flow' => $cash_flow_component
                ]);
            })->make(true);
        }

        return view('cashflow-component.index', ['active'=>'cashflow', 'title'=>'Komponen Neraca']);   
    }

}
