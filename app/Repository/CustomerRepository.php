<?php

namespace App\Repository;

use App\Interfaces\CustomerInterface;
use App\Model\Customer\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerInterface
{
    private $model;
    private $transaction;

    public function __construct(Customer $customer, TransactionRepository $transaction)
    {
        $this->model   = $customer;
        $this->transaction = $transaction;
    }

    public function sumnewCustomer()
    {
        return $this->model->whereMonth('created_at', '=', date('m'))->whereYear('created_at',date("Y"))->count();
    }
    
    /**
     * @return
     */
    public function sumOrder($customer_id)
    {
        $customer_user_name = $this->model->findOrfail($customer_id)->username_pembeli;

        if($customer_user_name != null)
        {
            return $this->transaction->countCustomer($customer_user_name); // Frekuensi Order
        }
        else
        {
            return 0;
        }
    }

    public function TotalCustomerByMonth($month)
    {
        if($month == null)
        {
            $month = Carbon::now()->month;
            $year  = date("Y");
        }
        
        return $this->model->whereMonth('created_at', $month)->whereYear('created_at',$year)->count();
    }

    public function getByUserName($username)
    {
        return $this->model->where('username_pembeli', $username)->first();
    }

    public function getAll($search = null, $param=null)
    {
        $data = $this->model->select('tbl_customer.*')->join('tbl_transaksi', 'tbl_customer.username_pembeli', '=', 'tbl_transaksi.username_pembeli')->where('tbl_customer.username_pembeli', 'like', '%'.$search.'%')->groupBy('tbl_customer.username_pembeli')->orderBy(DB::raw('COUNT(tbl_transaksi.username_pembeli)'), 'DESC')->limit(110);

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

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function checkIfExist($username)
    {
        $data = $this->model->where('username_pembeli', $username)->count();

        if($data >= 1)
        {
            return true;
        }

        return false;   
    }


}