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
    public static function getTransaksi()
    {
        $data = Transaksi::get();
        return $data;
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
    * @return double
    */
    public static function getTotalTransaksi()
    {
        return Transaksi::whereMonth('tgl_pesanan_dibuat', '=', date('m'))->count();
    }


    /**
    * @return int
    */
    public static function notPrint()
    {
        return Transaksi::where('status_cetak', Transaksi::BELUM_CETAK)->count();
    }

     /**
    * @return 
    */
     public static function countCustomer($customer_username)
     {
        return Transaksi::where('username_pembeli', $customer_username)->count();
     }

    /**
    * @return 
    */
    public static function getCustomer()
    {
        return Transaksi::whereMonth('tgl_pesanan_dibuat', '=', date('m'))->groupBy('username_pembeli')->orderByRaw('COUNT(*) DESC')->limit(1)->first();
    }


    /**
    * @return get All Transaksi
    */
    public function getAll($date_start=null, $date_end=null, $type_cetak, $customer=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();
        
        $data       = $this->transaksi;

        if($date_start != null && $date_start != null)
        {
            $data = $data->whereDate('tgl_pesanan_dibuat', '>=', $date_from)->whereDate('tgl_pesanan_dibuat', '<=', $date_to);
        }

        if($type_cetak == 'BELUM')
        {
            $data = $data->where('status_cetak', Transaksi::BELUM_CETAK);
        }
        else if($type_cetak == 'SUDAH')
        {
            $data = $data->where('status_cetak', Transaksi::SUDAH_CETAK);
        }

        if($customer != null)
        {
            $data = $data->where('username_pembeli', $customer);
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

        $pattern = '/produk/i';
        $product = preg_replace($pattern,'P', $product);

        $pattern = '/variasi/i';
        $product = preg_replace($pattern,'V', $product);

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