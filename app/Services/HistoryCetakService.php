<?php

namespace App\Services;

use App\Model\HistoryCetak\HistoryCetak;

use Auth;

use Carbon\Carbon;

class HistoryCetakService {

    protected $history_cetak;
    
	public function __construct(HistoryCetak $history_cetak)
	{
	    $this->history_cetak = $history_cetak;
    }

    /**
    * log Cetak into history Table
    */
    public function logIntoHistory($param)
    {
        $param = [
            'date_range'=> $param->dates,
            'user_toko_id' => isset($param->toko) ? $param->toko : null,
            'array_user' => isset($param->customer) ? implode("|",$param->customer) : null
        ];

        $model_history = new HistoryCetak($param);
        $model_history->save();
    }

    public function getAll($search = null)
    {
        return $this->history_cetak->where('date_range', 'like', '%'.$search.'%')->orderBy('id');
    }

}