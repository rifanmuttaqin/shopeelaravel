<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

use App\Model\Iklan\Iklan;

use App\Services\TokoService;

use App\Services\TopUpIklanService;

use DB;

class TopUpIklanController extends Controller
{
      public $iklan_service;
      public $toko_service;

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct(TopUpIklanService $iklan_service, TokoService $tokoService)
      {
            $this->middleware('auth');
            $this->iklan_service = $iklan_service;
            $this->toko_service = $tokoService;
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
           	$data = $this->iklan_service->getAll();

            return Datatables::of($data)->addColumn('action', function($row){  
                $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                return $delete; 
            })->make(true);
        }

        $daftar_toko = $this->toko_service->getAll();

        return view('iklan.index', ['active'=>'topupiklan', 'title'=> 'Transaksi Top Up Iklan', 'daftar_toko'=>$daftar_toko]);
    }


     /**
     * Store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if($request->ajax())
            {
                  dd($request->all());
            }
    }
}
