<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Model\Iklan\Iklan;
use App\Services\TokoService;
use App\Services\TopUpIklanService;
use App\Http\Requests\Iklan\StoreIklanRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TopUpiklanController extends Controller
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
            $this->iklan_service    = $iklan_service;
            $this->toko_service     = $tokoService;
      }

      /**
       * Filter data Purpose
       *
       * @return \Illuminate\Http\Response
       */
      public function filterdate(Request $request)
      {
            if ($request->ajax()) 
            {
                  $data = $this->iklan_service->getAll();          

                  if($request->get('date'))
                  {
                        $date_range   = explode(" - ",$request->get('date'));
                        $date_start   = date('Y-m-d',strtotime($date_range[0]));
                        $date_end     = date('Y-m-d',strtotime($date_range[1]));

                        $data = $this->iklan_service->getAll(null,$date_start,$date_end);
                  }
            
                  return Datatables::of($data)
                        ->addColumn('user_toko_id', function($row){  
                              return $this->toko_service->findById($row->user_toko_id)->nama_toko; 
                        })
                        ->addColumn('date', function($row){
                              return Carbon::parse($row->date)
                              ->format('d F Y');
                        })
                        ->addColumn('action', function($row){  
                        $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                        return $delete; 
                        })->make(true);
            }
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
                  if($request->get('date'))
                  {
                        $date_range   = explode(" - ",$request->get('date'));
                        $date_start   = date('Y-m-d',strtotime($date_range[0]));
                        $date_end     = date('Y-m-d',strtotime($date_range[1]));

                        $data = $this->iklan_service->getAll(null,$date_start,$date_end);
                  }
                  else
                  {
                        $data = $this->iklan_service->getAll();    
                  }

                  return Datatables::of($data)
                        ->addColumn('user_toko_id', function($row){  
                              return $this->toko_service->findById($row->user_toko_id)->nama_toko; 
                        })
                        ->addColumn('date', function($row){
                              return Carbon::parse($row->date)
                              ->format('d F Y');
                        })
                        ->addColumn('action', function($row){  
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
      public function store(StoreIklanRequest $request)
      {
            if($request->ajax())
            {
                  DB::beginTransaction();   
                  
                  $iklan_model               = new Iklan($request->param); // Menggunakan mass Assignment
                  $iklan_model->user_created = $this->getUserLogin()->id;
                  $iklan_model->date         = date("Y-m-d H:i:s", strtotime($request->param['date']));

                  if(!$iklan_model->save())
                  {
                        DB::rollBack();
                        return $this->getResponse(false,400,null,'Gagal');
                  }

                  DB::commit();
                  return $this->getResponse(true,200,null,'Berhasil');
            }
      }

      public function gettotaliklan(Request $request)
      {
            if($request->ajax())
            {   
                  $date_range   = explode(" - ",$request->get('dates'));

                  $date_start   = date('Y-m-d',strtotime($date_range[0]));
                  $date_end     = date('Y-m-d',strtotime($date_range[1]));
                  

                  $data = $this->iklan_service->getTotalByFilter($date_start, $date_end, null);
          
                  return $this->getResponse(true,200,$data,'Berhasil didapatkan');
            }
      }


      /**
       * Delete
       * @return \Illuminate\Http\Response
       */
      public function destroy(Request $request)
      {
            if($request->ajax())
            {
                  DB::beginTransaction();   

                  $iklan_model  = $this->iklan_service->findById($request->param);
                  
                  if(!$iklan_model->delete())
                  {
                        DB::rollBack();
                        return $this->getResponse(false,400,null,'Gagal');
                  }

                  DB::commit();
                  return $this->getResponse(true,200,null,'Berhasil');
            }
      }
}
