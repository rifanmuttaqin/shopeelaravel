<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

use App\Model\Transaksi\Transaksi;

use App\Services\TransaksiService;

class ReportTransaksiController extends Controller
{
    
    public $transaksi_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi_service)
    {
        $this->middleware('auth');
        $this->transaksi_service = $transaksi_service;
    }

    /**
     * Show the application transaksi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('transaksi-report.index', ['active'=>'transaksi-table', 'title'=>'Laporan Transaksi']);   
    }

    /**
     * Show the application transaksi grafik.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function grafik(Request $request)
    {
        return view('transaksi-report.grafik', ['active'=>'transaksi-grafik', 'title'=>'Laporan Grafik']);   
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTransaksiIncome(Request $request)
    {
        $type_cetak = $request->get('type_cetak');
        $toko       = $request->get('toko');
        $customer   = $request->get('customer');

        $date_start = null;
        $date_end   = null;

        if($request->get('dates'))
        {
            $date_range   = explode(" - ",$request->get('dates'));
            $date_start   = date('Y-m-d',strtotime($date_range[0]));
            $date_end     = date('Y-m-d',strtotime($date_range[1]));
        }

        $data = $this->transaksi_service->getTotalIncomeByFilter($date_start, $date_end, $request->get('type_cetak'), $request->get('customer'), $toko);

        return $this->getResponse(true,200,$data,'Berhasil didapatkan');
    }

}
