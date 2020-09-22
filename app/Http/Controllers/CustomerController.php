<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use App\Model\User\User;
use App\Model\Customer\Customer;

use App\Services\CustomerService;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = CustomerService::getAll();

            return Datatables::of($data)
            ->addColumn('sum_order', function($row){  
                    $data = CustomerService::sumOrder($row->id);
                        return $data; 
                    })
            ->make(true);
        }

        return view('customer.index', ['active'=>'customer', 'title'=> 'Database Customer']);
    }

    /**
     * List Customer
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->ajax())
        {
            $data_customer = null;
            $data_customer = CustomerService::getAll($request->get('search'));
          
            $arr_data      = array();

            if($data_customer != null)
            {
                $key = 0;

                foreach ($data_customer as $data) 
                {
                    $arr_data[$key]['id']   = $data->id;
                    $arr_data[$key]['text'] = $data->username_pembeli;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }
}
