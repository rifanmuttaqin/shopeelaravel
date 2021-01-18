<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\Transaksi\TransaksiImport;

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
        return view('transaksi.index', ['active'=>'transaksi', 'title'=>'Transaksi']);   
    }

    /**
     */
    public function doImport(Request $request)
    {
        if($request->hasFile('file'))
        {
            $file       = $request->file('file');

            $fileName   = time() . '.' . $file->getClientOriginalExtension();
            $path       = $file->getRealPath();
            $name       = $file->getClientOriginalName();
            $name       = explode(".",$name);
            $name       = $name[0];
                
            $run_import = Excel::import($import = new TransaksiImport($name, $transaksi_service, $toko_service, $customer_service), $file);

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
