<?php

namespace Modules\Pengeluaran\Services;

use Carbon\Carbon;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;

class TransaksiPoService {

    protected $transaksi;
    protected $supplier;

    public function __construct(TransaksiPo $transaksi, SupplierService $supplier)
    {
        $this->transaksi = $transaksi;
        $this->supplier = $supplier;
    }

    /**
     * @return
     */
    public function getAll($date_start=null, $date_end=null, $supplier=null)
    {
        $data = $this->transaksi->limit(50);

        if($date_start != null && $date_start != null)
        {
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        }

        if($supplier != null)
        {
            $data->where('supplier_name',$this->supplier->findById($supplier)->nama);
        }

        return $data->orderBy('created_at', 'DESC');
    }

    public function getTotalOutcomeByFilter($date_start=null, $date_end=null, $ori=null)
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

    public function TotalAmountByMonth($month=null,$year=null)
    {
        if($month == null)
        {
            $month = Carbon::now()->month;
            $year  = date("Y");
        }       

        $result = $this->transaksi->whereMonth('created_at',$month)->whereYear('created_at',$year)->sum('total_amount');
        $result = number_format($result, 0, ',', '.');

        return 'Rp '.$result;
    }

    /**
     * @return
     */
    public function findById($id)
    {
        return $this->transaksi->findOrFail($id);
    }

    public function getDetail($id)
    {
        return $this->findById($id)->detail;
    }

}