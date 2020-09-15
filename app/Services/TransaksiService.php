<?php

namespace App\Services;

use App\Model\Transaksi\Transaksi;


class TransaksiService {

	protected $transaksi;

	public function __construct()
	{
	    $this->transaksi = new Transaksi();
    }

    /**
    * @return int
    */
    public function checkIfExist($no_pesanan)
    {
    	$data = $this->transaksi->where('no_pesanan', $no_pesanan)->count();

    	if($data >= 1)
    	{
    		return true; // Benar Exist
    	}

    	return false;
    }


    /**
    * @return get All Transaksi
    */
    public function getAll()
    {
        return $this->transaksi->get();
    }

    /**
    * @return Jumlah data di table transaksi
    */
    public function countTotalData()
    {
        return $this->transaksi->count();
    }

}