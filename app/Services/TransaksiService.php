<?php

namespace App\Services;

use App\Model\Transaksi\Transaksi;
use App\Model\Customer\Customer;
use App\Services\CustomerService;

use Illuminate\Support\Arr;

use Auth;

use Carbon\Carbon;

class TransaksiService {

	protected $transaksi;

	public function __construct(Transaksi $transaksi)
	{
	    $this->transaksi = $transaksi;
    }

    /**
    * @return int
    */
    public function getTransaksi()
    {
        return $this->transaksi->get();
    }

    /**
    * @return Object
    */
    public function getByYear($tahun)
    {
        return $this->transaksi->whereYear('tgl_pesanan_dibuat', '=', $tahun)
            ->orderBy('tgl_pesanan_dibuat', 'asc')
            ->get()
            ->groupBy(function ($val) {
            return Carbon::parse($val->tgl_pesanan_dibuat)->format('F');
        });
    }

    public function TotalPaketByMonth($month=null)
    {
        if($month != null)
        {
            $month = Carbon::parse($month)->month;
        }
        else
        {
            $month = Carbon::now()->month;
        }

        return $this->transaksi->whereMonth('tgl_pesanan_dibuat', '=', $month)->count();
    }


    /**
    * @return int
    */
    public function checkIfExist($no_pesanan)
    {
    	if($this->transaksi->where('no_pesanan', $no_pesanan)->count() >= 1)
    	{
    		return true; // Benar Exist
    	}

    	return false;
    }

    /**
    * @return array
    */
    public static function findByNoPesanan($no_pesanan)
    {
        return Transaksi::where('no_pesanan', $no_pesanan)->first();
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
    public function getAll($date_start=null, $date_end=null, $type_cetak, $customers=null, $toko=null)
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

        if($customers != null)
        {
            $customer_array = [];

            foreach ($customers as $customer) 
            {
                array_push($customer_array, Customer::find($customer)->username_pembeli);
            }
            
            $data = $data->whereIn('username_pembeli', $customer_array);
        }

        if($toko != null)
        {
            $data = $data->where('user_toko_id', $toko);
        }
        
        return $data->get();
    }


    public function getTotalIncomeByFilter($date_start=null, $date_end=null, $type_cetak, $customer=null, $toko=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->transaksi->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

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

        if($toko != null)
        {
            $data = $data->where('user_toko_id', $toko);
        }

        return number_format($data->sum('pendapatan_bersih'),0,",",".");
    }


    public static function getTotalIncome()
    {
        return number_format(Transaksi::whereMonth('created_at', '=', date('m'))->sum('pendapatan_bersih'),0,",",".");
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

        $pattern = '/Nomor Referensi SKU:/i';
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