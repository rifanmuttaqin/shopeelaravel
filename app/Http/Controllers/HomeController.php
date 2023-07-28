<?php

namespace App\Http\Controllers;

use App\Interfaces\AdvertisementInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\TransactionInterface;
use Illuminate\Http\Request;
use Modules\Pemasukan\Services\TransaksiOfflineService;
use Modules\Pengeluaran\Interfaces\TransactionPoInterface;

class HomeController extends Controller
{
      private $transaction;
      private $customer;
      private $transaction_po;
      private $ads;
      
      private $transaksi_non_shopee;

      public function __construct(TransactionInterface $transaction, 
            CustomerInterface $customer,
            TransactionPoInterface $transaction_po,
            AdvertisementInterface $ads,
            TransaksiOfflineService $transaksi_non_shopee
      )

      {
            $this->transaction = $transaction;
            $this->customer = $customer;
            $this->transaction_po = $transaction_po;
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

      public function getCashFlow()
      {
            $result = [
                  'expense' => $this->transaction_po->TotalAmountByMonth(null,null,'ORIGINAL_RESULT') + $this->ads->getTotal('ORIGINAL_RESULT'),
                  'income' => $this->transaction->getTotalIncome('ORIGINAL_RESULT') + $this->transaksi_non_shopee->getTotalByMonthYear('ORIGINAL_RESULT')
            ];
            
            return response()->json($result);
      }


      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Contracts\Support\Renderable
       */
      public function index()
      {
            $notifications = auth()->user()->unreadNotifications;

            return view('home.index', [
                  'active'=>'home', 
                  'title'=>'Dashboard',
                  'notification' => $notifications
            ]);   
      }
}
