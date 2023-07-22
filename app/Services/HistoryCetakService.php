<?php

namespace App\Services;

use App\Model\HistoryCetak\HistoryCetak;

use App\Services\CustomerService;

use Auth;

use Carbon\Carbon;

class HistoryCetakService {

    protected $history_cetak;
    protected $customer;
    
	public function __construct(HistoryCetak $history_cetak, CustomerService $customer)
	{
	    $this->history_cetak = $history_cetak;
        $this->customer = $customer;
    }

    /**
    * log Cetak into history Table
    */
    public function logIntoHistory($param, $data)
    {
            $customer_array = [];

            foreach ($data as $transaksi) 
            {
                array_push($customer_array,$this->customer->getByUserName($transaksi->username_pembeli)->id);   
            }

            $param = [
                  'date_range'=> $param->dates,
                  'user_toko_id' => isset($param->toko) ? $param->toko : null,
                  'array_user' => isset($customer_array) ? implode("|",$customer_array) : null
            ];

            $model_history = new HistoryCetak($param);
            $model_history->save();
    }

    public function getAll($search = null)
    {
        return $this->history_cetak->where('date_range', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
    }

}