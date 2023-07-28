<?php

namespace Modules\Pemasukan\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;

class TransaksiOfflineService {

    protected $transaksi;

    public function __construct(TransaksiOffline $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * @return
     */
    public function getAll($date_start=null, $date_end=null, $search = null, $customer_name=null, $status_transaksi=null)
    {
        $data = $this->transaksi->where('invoice_code', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');

        if($date_start != null && $date_start != null)
        {
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        }

        if($customer_name != null)
        {
            $data->where('nama_customer',$customer_name);
        }

        if($status_transaksi != null)
        {
            $data->where('status_transaksi',$status_transaksi);
        }

        return $data;
    }

    public function getTotalByMonthYear($ori=null)
    {
        $data = $this->transaksi->whereMonth('created_at', '=', date('m'))->whereYear('created_at',date("Y"));

        if($ori === 'ORIGINAL_RESULT')
        {
            return $data->sum('total_amount');
        }
        else
        {
            return number_format($data->sum('total_amount'),0,",",".");
        }
    }

    public function getTotalIncomeByFilter($date_start=null, $date_end=null, $ori=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->transaksi->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        if($ori === 'ORIGINAL_RESULT')
        {
            return $data->sum('total_amount');
        }
        else
        {
            return number_format($data->sum('total_amount'),0,",",".");
        }
    }

    public function generateInvoiceCode()
    {
        $number = 'INV_'.mt_rand(1000000000, 9999999999); // better than rand()

        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateInvoiceCode();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    function barcodeNumberExists($number) {
        return $this->transaksi->where('invoice_code',$number)->exists();
    }

    /**
     * @return
     */
    public function findById($id)
    {
        return $this->transaksi->findOrFail($id);
    }

}