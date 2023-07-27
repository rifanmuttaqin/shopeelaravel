<?php

namespace App\Repository;

use App\Interfaces\CustomerInterface;
use App\Model\Customer\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerInterface
{
    private $model;

    public function __construct(Customer $customer)
    {
        $this->model   = $customer;
    }

    public function sumnewCustomer()
    {
        return $this->model->whereMonth('created_at', '=', date('m'))->whereYear('created_at',date("Y"))->count();
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


}