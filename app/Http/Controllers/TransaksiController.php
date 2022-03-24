<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Transaksi\TransaksiImport;
use App\Model\Transaksi\Transaksi;
use App\Http\Requests\Transaksi\UpdateTransaksiRequest;
use App\Services\TransaksiService;
use App\Services\CustomerService;
use App\Services\TokoService;
use Yajra\Datatables\Datatables;

class TransaksiController extends Controller
{
    public $transaksi_service;
    public $toko_service;
    public $customer_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi_service, CustomerService $customer_service, TokoService $toko_service)
    {
        $this->middleware('auth');
        $this->transaksi_service = $transaksi_service;
        $this->toko_service    = $toko_service;
        $this->customer_service = $customer_service;
    }

    /**
     * Show the application transaksi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $daftar_toko = $this->toko_service->getAll()->get();
        return view('transaksi.index', ['active'=>'transaksi', 'title'=>'Transaksi', 'daftar_toko' => $daftar_toko]);   
    }

    public function list(Request $request)
    {
        $data = null;   
        $data = $this->transaksi_service->getAll(null, null, null, null, null, $request->get('search'))->get();
        $arr_data      = array();

        if($data != null)
        {
            $key = 0;

            foreach ($data as $datas) 
            {
                $arr_data[$key]['id']   = $datas->id;
                $arr_data[$key]['text'] = $datas->no_resi;
                $key++;
            }
        }

        return json_encode($arr_data);
    }


    /**
     * Update transaksi by adding keterangan
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(UpdateTransaksiRequest $request)
    {
        if($request->ajax())
        {
            $transaksi_model = Transaksi::findOrFail($request->id)->update($request->all());

            if($transaksi_model)
            {
                return $this->getResponse(true,200,'','Catatan Ditambahkan');
            }
        }
    }


    public function listpage(Request $request)
    {
        if($request->ajax()){
            
            $data = $this->transaksi_service->getAll(null, null, null, null, null, null);

            return Datatables::of($data)
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })->make(true);
        }

        return view('transaksi.listpage', ['active'=>'list-transaksi', 'title'=> 'Data Penjualan Shopee']);
    }


    /**
     */
    public function doImport(Request $request)
    {
        if($request->hasFile('file'))
        {
            $file       = $request->file('file');
            $toko_name  = $request->get('toko_name');
            $import     = new TransaksiImport($toko_name, $this->transaksi_service, $this->toko_service, $this->customer_service);
            
            Excel::import($import, $file);

            if($import->result)
            {
                return redirect('transaksi')->with('alert_success', 'Berhasil Diimport | Silahkan lanjut ke pencetakkan');
            }
            else
            {
                return redirect('transaksi')->with('alert_error', 'TERDAPAT KESALAHAN PADA FORMAT DATA');
            }
        }
        else
        {
            return redirect('transaksi')->with('alert_error', 'FILE KOSONG | Masukkan File Sesuai dengan FORMAT');
        }
    }

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl    = route('show-transaksi', $data->id);
        $deleteUrl  = route('delete-transaksi', $data->id);
        
        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
    }
    
}
