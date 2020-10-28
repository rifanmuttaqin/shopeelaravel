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
        return view('transaksi-report.index', ['active'=>'transaksi', 'title'=>'Laporan Transaksi']);   
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

}
