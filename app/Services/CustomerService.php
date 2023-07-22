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
      public function getAll($search = null, $param=null)
      {
            $data = $this->customer->select('tbl_customer.*')->join('tbl_transaksi', 'tbl_customer.username_pembeli', '=', 'tbl_transaksi.username_pembeli')->where('tbl_customer.username_pembeli', 'like', '%'.$search.'%')->groupBy('tbl_customer.username_pembeli')->orderBy(DB::raw('COUNT(tbl_transaksi.username_pembeli)'), 'DESC')->limit(110);

            if($param != null) {
                  if(array_key_exists('order_more_than_twice', $param)) {
                       $data->havingRaw('COUNT(tbl_transaksi.username_pembeli) > 3');
                  }

                  if(array_key_exists('first_time', $param)) {
                        $data->havingRaw('COUNT(tbl_transaksi.username_pembeli) = 1');
                  }

                  if(array_key_exists('not_include_undefined', $param)) {
                        $data->whereNotIn('tbl_customer.telfon_pembeli',['UNDEFINED']);
                  }

                  if(array_key_exists('kabupaten_kota', $param)){
                        $data->where('tbl_customer.kota_pembeli','like', '%'.$param['kabupaten_kota'].'%');
                  }

                  if(array_key_exists('provinsi', $param)){
                        $data->where('tbl_customer.provinsi_pembeli','like', '%'.$param['provinsi'].'%');
                  }
            }     

            return $data;
      }

}