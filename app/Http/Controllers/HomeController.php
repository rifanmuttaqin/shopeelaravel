<?php

namespace App\Http\Controllers;

use App\Interfaces\AdvertisementInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\TransactionInterface;
use Illuminate\Http\Request;
use Modules\Pemasukan\Services\TransaksiOfflineService;
use Modules\Pengeluaran\Services\TransaksiPoService;

class HomeController extends Controller
{
      private $transaction;
      private $customer;
      private $transaksi_po_service;
      private $ads;
      private $transaksi_non_shopee;

      public function __construct(TransactionInterface $transaction, 
            CustomerInterface $customer,
            TransaksiPoService $transaksi_po_service,
            AdvertisementInterface $ads,
            TransaksiOfflineService $transaksi_non_shopee
      )

      {
            $this->transaction = $transaction;
            $this->customer = $customer;
            $this->transaksi_po_service = $transaksi_po_service;
            $this->ads = $ads;
            $this->transaksi_non_shopee = $transaksi_non_shopee;

            $this->middleware('auth');
      }

      public function getTransactionInfo(Request $request)
      {
           if($request->ajax())
           {
                  $result = [
                        'package_total' => $this->transaction->getTotalTransaksi(),
                        'best_cutomer'  => $this->transaction->getBestCustomer(),
                        'not_printed'   => $this->transaction->notPrint(),
                  ];

                  return response()->json($result);
           }

      }

      public function getCustomerInfo()
      {
            $result = [
                  'new_customer' => $this->customer->sumnewCustomer(),
            ];

            return response()->json($result);
      }

      public function getExpenseInfo()
      {
            $pengeluaran =  $this->transaksi_po_service->TotalAmountByMonth(null,null,'ORIGINAL_RESULT') + $this->ads->getTotal('ORIGINAL_RESULT');
      }

      public function incomeInfo()
      {

      }


      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Contracts\Support\Renderable
       */
      public function index()
      {
            $notifications = auth()->user()->unreadNotifications;

            $pengeluaran =  $this->transaksi_po_service->TotalAmountByMonth(null,null,'ORIGINAL_RESULT') + $this->ads->getTotal('ORIGINAL_RESULT');
            $pemasukan = $this->transaction->getTotalIncome('ORIGINAL_RESULT') + $this->transaksi_non_shopee->getTotalByMonthYear('ORIGINAL_RESULT'); 

            return view('home.index', [
                  'active'=>'home', 
                  'title'=>'Dashboard',
                  'pemasukan'=>$pemasukan,
                  'notifications'=>$notifications,
                  'pengeluaran'=>$pengeluaran,
                  'iklan_service'=>$this->ads
            ]);   
      }
}
