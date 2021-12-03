<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Modules\Pengeluaran\Services\TransaksiPoService;

class HomeController extends Controller
{
      private $transaksi_service;
      private $customer_service;
      private $transaksi_po_service;

      public function __construct(TransaksiService $transaksi_service, CustomerService $customer_service, TransaksiPoService $transaksi_po_service)
      {
            $this->transaksi_service = $transaksi_service;
            $this->customer_service = $customer_service;
            $this->transaksi_po_service = $transaksi_po_service;

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

            return view('home.index', [
                  'active'=>'home', 
                  'title'=>'Dashboard',
                  'transaksi_service'=>$this->transaksi_service,
                  'customer_service'=>$this->customer_service,
                  'notifications'=>$notifications,
                  'transaksi_po_service'=>$this->transaksi_po_service,
            ]);   
      }
}
