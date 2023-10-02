<?php

namespace App\Repository;

use App\Interfaces\CashFlowTransactionInterface;
use App\Model\CashFlow\CashFlowTransaction;
use Carbon\Carbon;

class CashFlowTransactionRepository implements CashFlowTransactionInterface
{
    private $model;

    public function __construct(CashFlowTransaction $cashflow)
    {
        $this->model   = $cashflow;
    }

    public function getAll($search=null)
    {
        return $this->model->with('cashFlow')->when(request()->search, function ($query) {
            if (!is_array(request()->search)) {
                $query->whereRelation('cashFlow', 'category_name', '%','LIKE','%' . request()->search . '%');
            }
        })->orderBy('created_at', 'DESC');
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function countIncome()
    {
        $date_from  = Carbon::parse(request()->get('date_start'))->startOfDay();
        $date_to    = Carbon::parse(request()->get('date_end'))->endOfDay();

        $data = $this->model->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to)
            ->when(request()->search, function ($query) {});

        // $data = $this->transaksi->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        // if($type_cetak == 'BELUM')
        // {
        //         $data = $data->where('status_cetak', Transaksi::BELUM_CETAK);
        // }
        // else if($type_cetak == 'SUDAH')
        // {
        //         $data = $data->where('status_cetak', Transaksi::SUDAH_CETAK);
        // }

        // if($customer != null)
        // {
        //         $data = $data->where('username_pembeli', $customer);
        // }

        // if($toko != null)
        // {
        //         $data = $data->where('user_toko_id', $toko);
        // }

        // if($ori === 'ORIGINAL_RESULT')
        // {
        //         return $data->sum('pendapatan_bersih');
        // }
        // else
        // {
        //         return number_format($data->sum('pendapatan_bersih'),0,",",".");
        // }

    }

    public function countOutcome()
    {
        
    }

    public function meaning($param)
    {
        switch ($param) {
            case CashFlowTransaction::RECEIPT;
                return CashFlowTransaction::RECEIPT_STRING; 
            case CashFlowTransaction::SPENDING;
                return CashFlowTransaction::SPENDING_STRING;            
            default:
                return 'Not available';        }
    }

}