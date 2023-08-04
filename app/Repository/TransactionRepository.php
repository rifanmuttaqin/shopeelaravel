<?php

namespace App\Repository;

use App\Interfaces\TransactionInterface;
use App\Model\Customer\Customer;
use App\Model\Transaksi\Transaksi;
use Carbon\Carbon;

class TransactionRepository implements TransactionInterface
{
    private $model;
    private $customer;

    public function __construct(Transaksi $model, Customer $customer)
    {
        $this->model   = $model;
        $this->customer = $customer;
    }

    /**
     * @return
     */
    public function getTransaksi()
    {
        return $this->model->get();
    }

    /**
     * @return
     */
    public function getByYear($tahun)
    {
        return $this->model->whereYear('tgl_pesanan_dibuat', '=', $tahun)
            ->orderBy('tgl_pesanan_dibuat', 'asc')
            ->get()
            ->groupBy(function ($val) {
            return Carbon::parse($val->tgl_pesanan_dibuat)->format('F');
        });
    }

    public function getTotalByDate($date)
    {
        return $this->model->whereDate('tgl_pesanan_dibuat',$date)->count();
    }

    public function TotalPaketByMonth($month=null,$year=null)
    {
        if($month == null)
        {
            $month = Carbon::now()->month;
            $year  = date("Y");
        }       

        $result = $this->model->whereMonth('tgl_pesanan_dibuat',$month)->whereYear('tgl_pesanan_dibuat',$year)->count();

        return $result;
    }

    public function notPrint()
    {
        return $this->model->where('status_cetak',Transaksi::BELUM_CETAK)->count();
    }

    public function getTotalTransaksi()
    {
        return  $this->model->whereMonth('tgl_pesanan_dibuat', Carbon::now()->month)->whereYear('tgl_pesanan_dibuat',date("Y"))->count();
    }


    public function getBestCustomer()
    {
        $data = $this->model->whereMonth('tgl_pesanan_dibuat', '=', date('m'))->whereYear('tgl_pesanan_dibuat',date("Y"))->groupBy('username_pembeli')->orderByRaw('COUNT(*) DESC')->limit(1)->first();
        $data = $data != null ? $data->username_pembeli : 0;
        
        return $data;
    }

    public function findByNoPesanan($param)
    {
        return $this->model->where('no_pesanan',$param)->first();
    }

    public function getCompareTransaction()
    {
        $today = $this->getTotalByDate(Carbon::today());
        $yesterday =  $this->getTotalByDate(Carbon::yesterday());
        $percentage = ($today - $yesterday) / $yesterday * 100;

        $sign = $percentage >= 0 ? '+' : '-';
        
        return sprintf("%s%.2f%%", $sign, abs($percentage));
    }

    /**
     * @return
     */
    public function checkIfExist($no_pesanan)
    {
        if($this->model->where('no_pesanan', $no_pesanan)->count() >= 1)
        {
            return true; // Benar Exist
        }

        return false;
    }


    /**
    * @return
    */
    public function getAll($date_start=null, $date_end=null, $type_cetak=null, $customers=null, $toko=null, $search=null,$transaksi_id=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();
        
        $data       = $this->model->orderBy('tgl_pesanan_dibuat', 'DESC');

        if($transaksi_id != null){
            $data = $data->where('id',$transaksi_id);
        }
        
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
            if(is_array($customers))
            {
                $customer_array = [];

                foreach ($customers as $customer) 
                {
                    array_push($customer_array, $this->customer->find($customer)->username_pembeli);
                }

                $data = $data->whereIn('username_pembeli', $customer_array);
            }
            else
            {
                $data = $data->where('username_pembeli', $this->customer->find($customers)->username_pembeli);
            }
        }

        if($toko != null)
        {
            $data = $data->where('user_toko_id', $toko);
        }
        else
        {
                $data = $data->orderBy('tgl_pesanan_dibuat', 'desc');
        }

        if($search != null) {
                $data->where('no_resi', 'like', '%'.$search.'%')->limit(20);
        }
        else{
            $data->limit(1000);
        }
        
        return $data;
    }


    public function getTotalIncomeByFilter($date_start=null, $date_end=null, $type_cetak, $customer=null, $toko=null, $ori=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->model->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

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

        if($ori === 'ORIGINAL_RESULT')
        {
            return $data->sum('pendapatan_bersih');
        }
        else
        {
            return number_format($data->sum('pendapatan_bersih'),0,",",".");
        }

    }


    public function getTotalIncome($ori=null)
    {
        $result = $this->model->whereMonth('created_at', '=', date('m'))->whereYear('created_at',date("Y"))->sum('pendapatan_bersih');

        if($ori == 'ORIGINAL_RESULT')
        {
            return $result;
        }
        
        return number_format($result,0,",",".");
    }

    public function countCustomer($param)
    {
        return $this->model->where('username_pembeli', $param)->count();
    }
    
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @return
     */
    public function countTotalData()
    {
        return $this->model->count();
    }

    /**
     * @return
     */
    public function productExplode($product)
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

        $pattern = '/variasi:/i';
        $product = preg_replace($pattern,'', $product);

        $pattern = '/produk:/i';
        $product = preg_replace($pattern,'', $product);

        $pattern = '/Nomor Referensi SKU:/i';
        $product = preg_replace($pattern,'', $product);

        $pattern = '/;/i';
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