<?php

namespace Modules\Pemasukan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pemasukan\Services\CustomerOfflineService;
use Yajra\Datatables\Datatables;


class CustomerOfflineController extends Controller
{
    private $customer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerOfflineService $customer)
    {
        $this->middleware('auth');
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->customer->getAll();

            return Datatables::of($data)
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })->make(true);
        }

        return view('pemasukan::customer.index',['active'=>'customer-offline', 'title'=> 'Daftar Pelanggan Offline']);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pemasukan::customer.create',['active'=>'customer-offline', 'title'=> 'Penambahan Pelanggan Offline']);
    }



    // --------------- HELPER FUNCTION --------------

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl    = route('customer-offline-show', $data->id);
        $editUrl    = route('customer-offline-edit', $data->id);
        $deleteUrl  = route('customer-offline-delete', $data->id);
        
        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
        <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
    }

}
