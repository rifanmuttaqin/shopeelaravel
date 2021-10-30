<?php

namespace App\Http\Controllers;

use App\Imports\UpdateUser\UpdateUserImport;
use Yajra\Datatables\Datatables;
use App\Services\CustomerService;
use App\Services\TransaksiService;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    private $customer_service;
    private $transaksi;

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct(CustomerService $customer_service, TransaksiService $transaksi)
      {
            $this->middleware('auth');
            $this->customer_service = $customer_service;
            $this->transaksi = $transaksi;
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
            $data = $this->customer_service->getAll();

            return Datatables::of($data)
            ->addColumn('sum_order', function($row){  
                        $data = $this->customer_service->sumOrder($row->id);
                        return $data; 
                        })
            ->make(true);
            }

            return view('customer.index', ['active'=>'customer', 'title'=> 'Database Customer']);
      }


      public function listorder(Request $request)
      {
            if($request->ajax())
            {
                  //id_customer

                  $data            = new Collection();
                  $transaksi       = $this->transaksi->getAll(null, null , null , $request->get('id_customer'), null);

                        foreach ($transaksi as $transaksi_data) 
                        {
                                    $data->push([
                                          'id'                 => $transaksi_data->id,
                                          'no_resi'            => $transaksi_data->no_resi,
                                          'telfon_pembeli'     => $transaksi_data->telfon_pembeli,
                                          'alamat_pembeli'     => $transaksi_data->alamat_pembeli,
                                          'nama_pembeli'       => $transaksi_data->nama_pembeli,
                                          'produk'             => $transaksi_data->produk,
                                          'tgl_pesanan_dibuat' => $transaksi_data->tgl_pesanan_dibuat,
                                          'pendapatan_bersih'  => $transaksi_data->pendapatan_bersih,
                                          'catatan_order'      => $transaksi_data->catatan_order,
                                    ]);
                        }   

                        return Datatables::of($data)->make(true);  
            }   
      }

      public function edit()
      {
            return view('customer.edit', ['active'=>'customer', 'title'=> 'Pembaharuan Customer']);
      }

      public function update(Request $request)
      {
            if($request->hasFile('file'))
            {
                  $result = $this->doImport($request->file('file'));

                  if($result)
                  {
                        return view('customer.partial_upload_success')->render();
                  }
                  else
                  {
                        return view('customer.partial_upload_error')->render();
                  }

            }
      }

      private function doImport($param)
      {
            $import     = new UpdateUserImport($this->customer_service);

            Excel::import($import, $param);

            if(!$import->result)
            {
                return false;
            }

            return true;
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
                  
                  $data_customer = $this->customer_service->getAll($request->get('search'));
                  
                  $arr_data      = array();

                  if($data_customer != null)
                  {
                        $key = 0;

                        foreach ($data_customer->get() as $data) 
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
