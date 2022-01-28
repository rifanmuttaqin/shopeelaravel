<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\TopUpIklanService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Modules\Pemasukan\Services\TransaksiOfflineService;
use Modules\Pengeluaran\Services\TransaksiPoService;

class HomeController extends Controller
{
      private $transaksi_service;
      private $customer_service;
      private $transaksi_po_service;
      private $iklan_service;
      private $transaksi_non_shopee;

      public function __construct(TransaksiService $transaksi_service, 
            CustomerService $customer_service, 
            TransaksiPoService $transaksi_po_service,
            TopUpIklanService $iklan_service,
            TransaksiOfflineService $transaksi_non_shopee
      )

      {
            $this->transaksi_service = $transaksi_service;
            $this->customer_service = $customer_service;
            $this->transaksi_po_service = $transaksi_po_service;
            $this->iklan_service = $iklan_service;
            $this->transaksi_non_shopee = $transaksi_non_shopee;

            $this->middleware('auth');
      }

      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Contracts\Support\Renderable
       */
      public function index(Request $request)
      {
            $notifications = auth()->user()->unreadNotifications;

            $pengeluaran =  $this->transaksi_po_service->TotalAmountByMonth(null,null,'ORIGINAL_RESULT') + $this->iklan_service->getTotal('ORIGINAL_RESULT');
            $pemasukan = $this->transaksi_service->getTotalIncome('ORIGINAL_RESULT') + $this->transaksi_non_shopee->getTotalByMonthYear('ORIGINAL_RESULT'); 

            return view('home.index', [
                  'active'=>'home', 
                  'title'=>'Dashboard',
                  'transaksi_service'=>$this->transaksi_service,
                  'pemasukan'=>$pemasukan,
                  'customer_service'=>$this->customer_service,
                  'notifications'=>$notifications,
                  'pengeluaran'=>$pengeluaran,
                  'iklan_service'=>$this->iklan_service
            ]);   
      }
}
