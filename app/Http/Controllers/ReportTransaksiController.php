<?php

namespace App\Http\Controllers;

use App\Interfaces\CustomerInterface;
use Illuminate\Http\Request;
use App\Services\TransaksiService;

class ReportTransaksiController extends Controller
{
    public $transaksi_service;
    public $customer_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi_service, CustomerInterface $customer_service)
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
                  $name_of_month    = [];
                  $jumlah_paket     = [];
                  $jumlah_customer_baru = [];

                  for ($m=1; $m<=12; $m++) 
                  {
                        $result = date('F', mktime(0,0,0,$m, 1, date('Y')));
                        array_push($name_of_month,$result);
                  }

                  foreach ($name_of_month as $key => $month) 
                  {
                        $key +=1;
                        
                        array_push($jumlah_paket, $this->transaksi_service->TotalPaketByMonth($key,$request->get('tahun')));
                        array_push($jumlah_customer_baru, $this->customer_service->TotalCustomerByMonth($key,$request->get('tahun')));
                  }

                  $data = ['sumbu_x' => $name_of_month, 'jumlah_paket'=>$jumlah_paket, 'jumlah_customer_baru'=>$jumlah_customer_baru];
                  
                  return $data;
            }
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTransaksiIncome(Request $request)
    {
            $toko       = $request->get('toko');
            

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
