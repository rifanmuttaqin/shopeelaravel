<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

use App\Model\Transaksi\Transaksi;

use App\Services\TransaksiService;

class ReportTransaksiController extends Controller
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
     * Show the application transaksi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = TransaksiService::getTransaksi();

            return Datatables::of($data)
            ->addColumn('produk', function($row){  
                $data = TransaksiService::productExplode($row->produk);
                return $data; 
            })
            ->addColumn('status_cetak', function($row){  
               
               if($row->status_cetak == Transaksi::BELUM_CETAK)
               {
                    return 'BELUM';
               }
               else
               {
                    return 'SUDAH';
               }
            
            })
            ->rawColumns(['produk'])
            ->make(true);
        }

        return view('transaksi-report.index', ['active'=>'transaksi', 'title'=>'Laporan Transaksi']);   
    }

}
