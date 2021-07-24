<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\Transaksi\TransaksiImport;

use App\Model\Transaksi\Transaksi;

use App\Http\Requests\Transaksi\UpdateTransaksiRequest;
use App\Http\Requests\Transaksi\StoreTransaksiRequest;

use App\Services\TransaksiService;
use App\Services\CustomerService;
use App\Services\TokoService;

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
    public function index(Request $request)
    {
        $daftar_toko = $this->toko_service->getAll();
        return view('transaksi.index', ['active'=>'transaksi', 'title'=>'Transaksi', 'daftar_toko' => $daftar_toko]);   
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
    
}
