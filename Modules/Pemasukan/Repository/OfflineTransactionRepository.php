<?php

namespace Modules\Pemasukan\Repository;

use Carbon\Carbon;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline as TransactionOffline;
use Modules\Pemasukan\Interfaces\OfflineTransactionInterface;

class OfflineTransactionRepository implements OfflineTransactionInterface
{
    protected $model;

    public function __construct(TransactionOffline $model)
    {
        $this->model = $model;
    }

    /**
     * @return
     */
    public function getAll($date_start=null, $date_end=null, $search = null, $customer_name=null, $status_transaksi=null, $limit = null)
    {
        // refactoring note = simpelkan ke query when condition

        $data = $this->model->where('invoice_code', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');

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

        if($limit != null)
        {
            $data->limit(20);
        }

        return $data;
    }

    public function getTotalByMonthYear($ori=null)
    {
        // refactoring note = simpelkan ke query when condition
        $data = $this->model->whereMonth('date', '=', date('m'))->whereYear('date',date("Y"));

        if($ori === 'ORIGINAL_RESULT')
        {
            return $data->sum('total_amount');
        }
        else
        {
            return number_format($data->sum('total_amount'),0,",",".");
        }
    }

    public function getTotalByDate($date)
    {
        return $this->model->whereDate('date',$date)->count();
    }


    public function getTotalIncomeByFilter($date_start=null, $date_end=null, $ori=null)
    {
        // refactoring note = simpelkan ke query when condition
        
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->model->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

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


    public function getCompareTransaction()
    {
        $today = $this->getTotalByDate(Carbon::today());
        $yesterday =  $this->getTotalByDate(Carbon::yesterday());

        if ($yesterday > 0) {
            $percentage = ($today - $yesterday) / $yesterday * 100;
        } else {
            $percentage = 0;
        }

        $sign = $percentage >= 0 ? '+' : '-';
        
        return sprintf("%s%.2f%%", $sign, abs($percentage));
    }


    public function store($data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }

    public function update($model, $data)
    {
        return $this->findById($model->id)->update($data);
    }

    public function updateOrCreate(array $unique_attribute, array $target_attribute)
    {
        return $this->model->updateOrCreate($unique_attribute,$target_attribute);
    }

    private function barcodeNumberExists($number) {
        return $this->model->where('invoice_code',$number)->exists();
    }

}
