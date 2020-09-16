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

    /**
    * @return Normalisasi Product List
    */
    public static function productExplode($product)
    {
        $pattern = '/(?=\[)(.*)(?<=\])/';
        $product = preg_replace($pattern, '||', $product);

        $pattern = '/harga:/i';
        $product = preg_replace($pattern,'', $product);

        $pattern = '/jumlah:/i';
        $product = preg_replace($pattern,'', $product);

        $pattern = '/Rp/';
        $product = preg_replace($pattern,'', $product);

        $pattern = '/nama/i';
        $product = preg_replace($pattern,'', $product);

        return $product;
    }

}