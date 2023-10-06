<?php

namespace App\Http\Controllers;

use App\Interfaces\AdvertisementInterface;
use App\Interfaces\CashFlowTransactionInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\TransactionInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;
use Modules\Pemasukan\Interfaces\OfflineTransactionInterface;
use Modules\Pengeluaran\Interfaces\TransactionPoInterface;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
      private $transaction;
      private $customer;
      private $transaction_po;
      private $ads;
      private $offline_transaction;
      private $cashflow;

      public function __construct(TransactionInterface $transaction, 
            CustomerInterface $customer,
            TransactionPoInterface $transaction_po,
            AdvertisementInterface $ads,
            OfflineTransactionInterface $offline_transaction,
            CashFlowTransactionInterface $cashflow,

      )

      {
            $this->transaction = $transaction;
            $this->customer = $customer;
            $this->transaction_po = $transaction_po;
            $this->ads = $ads;
            $this->offline_transaction = $offline_transaction;
            $this->cashflow = $cashflow;

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

      public function salesOfflineChart(Request $request)
      {
            if($request->ajax()){

                  $date = [];
                  $dataseet = [];
                  $startOfWeek = Carbon::now()->startOfWeek(); 

                  for ($i = 0; $i < 7; $i++) {
                        $date[] = $startOfWeek->addDays($i)->format('d M Y');
                        $dataseet[] = $this->offline_transaction->getTotalByDate($startOfWeek->addDays($i)->format('Y-m-d'));
                  }

                  return ['label' => $date, 'dataseet' =>$dataseet];
            }
      }

      public function salesOnlineChart(Request $request)
      {
            if($request->ajax()){

                  $date = [];
                  $dataseet = [];
                  $startOfWeek = Carbon::now()->startOfWeek(); 

                  for ($i = 0; $i < 7; $i++) {
                        $date[] = $startOfWeek->addDays($i)->format('d M Y');
                        $dataseet[] = $this->transaction->getTotalByDate($startOfWeek->addDays($i)->format('Y-m-d'));
                  }

                  return ['label' => $date, 'dataseet' =>$dataseet];
            }
      }

      public function salesComparison(Request $request)
      {
            if($request->ajax())
            {
                  return response()->json($this->transaction->getCompareTransaction());
            }
      }

      public function salesComparisonOffline(Request $request)
      {
            if($request->ajax())
            {
                  return response()->json($this->offline_transaction->getCompareTransaction());
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
            $cashflow_account_expense = $this->cashflow->countOutcome();
            $cashflow_account_income = $this->cashflow->countIncome();
            
            $expense_total = $this->transaction_po->TotalAmountByMonth(null,null,'ORIGINAL_RESULT') + 
            $this->ads->getTotal('ORIGINAL_RESULT') + $cashflow_account_expense;

            $income_total = $this->transaction->getTotalIncome('ORIGINAL_RESULT') 
            + $this->offline_transaction->getTotalByMonthYear('ORIGINAL_RESULT') + $cashflow_account_income;
            
            return response()->json(['expense'=> $expense_total,'income'=>$income_total]);
      }

      public function offlineTransactionToday()
      {
            // get 10th list offline transaction everyday,
            $data = $this->offline_transaction->getAll(Carbon::now()->toDateString(),Carbon::now()->toDateString(),null,null,null,20);

            return DataTables::of($data)
            ->addColumn('status_transaksi', function($row){  
                return TransaksiOffline::defineStatus($row->status_transaksi);
            })
            ->addColumn('created_at', function($row){  
                return $row->created_at;
            })->make(true);
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
