<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

use App\Model\Transaksi\Transaksi;

use App\Services\TransaksiService;
use App\Services\CustomerService;

use Illuminate\Support\Collection;

class ReportTransaksiController extends Controller
{
    public $transaksi_service;
    public $customer_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi_service, CustomerService $customer_service)
    {
        $this->middleware('auth');
        $this->transaksi_service = $transaksi_service;
        $this->customer_service = $customer_service;
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

    public function grafikShow(Request $request)
    {
        if($request->ajax())
        {
            $tahun = $request->get('tahun');

            $month = [];
            $jumlah_paket = [];
            $jumlah_customer_baru = [];

            $data_transaksi = $this->transaksi_service->getByYear($request->get('tahun'));

            foreach ($data_transaksi as $bulan => $transaksi) 
            {
                array_push($month, $bulan);
                array_push($jumlah_paket, $this->transaksi_service->TotalPaketByMonth($bulan));
                array_push($jumlah_customer_baru, $this->customer_service->TotalCustomerByMonth($bulan));
            }

            $data = ['sumbu_x' => $month, 'jumlah_paket'=>$jumlah_paket, 'jumlah_customer_baru'=>$jumlah_customer_baru];

            return $data;
        }
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
