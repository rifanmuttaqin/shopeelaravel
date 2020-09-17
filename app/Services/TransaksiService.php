<?php

namespace App\Services;

use App\Model\Transaksi\Transaksi;

use Carbon\Carbon;


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
    * @return 
    */
     public static function countCustomer($customer_username)
     {
        return Transaksi::where('username_pembeli', $customer_username)->count();
     }


    /**
    * @return get All Transaksi
    */
    public function getAll($date_start=null, $date_end=null, $type_cetak)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->transaksi->whereDate('tgl_pesanan_dibuat', '>=', $date_from)->whereDate('tgl_pesanan_dibuat', '<=', $date_to);

        if($type_cetak == 'BELUM')
        {
            $data = $data->where('status_cetak', Transaksi::BELUM_CETAK);
        }
        
        return $data->get();
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

        $product = ltrim($product, $product[0]);
        $product = explode("||",$product);

        if($product != null)
        {
            $result = null;

            foreach ($product as $product_list) 
            {
                $result .= "<li>".$product_list ."</li>";
            }

            return $result;
        }
        else
        {
            return null;
        }
    }

}