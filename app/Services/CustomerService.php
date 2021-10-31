<?php

namespace App\Services;

use App\Model\Customer\Customer;
use App\Services\TransaksiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerService {

      protected $customer;
      protected $transaksi;

      public function __construct(Customer $customer, TransaksiService $transaksi)
      {
            $this->customer = $customer;
            $this->transaksi = $transaksi;
      }

      /**
       * @return
      */
      public function checkIfExist($username_pembeli)
      {
            $data = $this->customer->where('username_pembeli', $username_pembeli)->count();

            if($data >= 1)
            {
                  return true; // Benar Exist
            }

            return false;
      }

      /**
       * @return
      */
      public function sumnewCustomer()
      {
            return $this->customer->whereMonth('created_at', '=', date('m'))->whereYear('created_at',date("Y"))->count();
      }

      public function TotalCustomerByMonth($month=null,$year=null)
      {
            if($month == null)
            {
                  $month = Carbon::now()->month;
                  $year  = date("Y");
            }
            
            return $this->customer->whereMonth('created_at', $month)->whereYear('created_at',$year)->count();
      }


      /**
       * @return
      */
      public function getByUserName($username)
      {
            return $this->customer->where('username_pembeli', $username)->first();
      }


      /**
       * @return
      */
      public function sumOrder($customer_id)
      {
            $customer_user_name = $this->customer->findOrfail($customer_id)->username_pembeli;

            if($customer_user_name != null)
            {
                  return $this->transaksi->countCustomer($customer_user_name);
            }
            else
            {
                  return 0;
            }
      }


      /**
       * @return
      */
      public function getAll($search = null)
      {
            return $this->customer->select('tbl_customer.*')->join('tbl_transaksi', 'tbl_customer.username_pembeli', '=', 'tbl_transaksi.username_pembeli')->where('tbl_customer.username_pembeli', 'like', '%'.$search.'%')->groupBy('tbl_customer.username_pembeli')->orderBy(DB::raw('COUNT(tbl_transaksi.username_pembeli)'), 'DESC');
      }

}