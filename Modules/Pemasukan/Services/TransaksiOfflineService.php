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
    public function getAll($date_start=null, $date_end=null, $search = null)
    {
        $data = $this->transaksi->where('invoice_code', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');

        if($date_start != null && $date_start != null)
        {
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        }

        return $data;
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