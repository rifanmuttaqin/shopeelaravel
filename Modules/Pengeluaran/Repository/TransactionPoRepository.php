<?php

namespace Modules\Pengeluaran\Repository;

use Carbon\Carbon;
use Modules\Pengeluaran\Entities\Supplier\Supplier;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo as TransactionPo;
use Modules\Pengeluaran\Interfaces\TransactionPoInterface;


class TransactionPoRepository implements TransactionPoInterface
{
    protected $model;
    protected $supplier;

    public function __construct(TransactionPo $model, Supplier $supplier)
    {
        $this->model = $model;
        $this->supplier = $supplier;
    }

    public function getAll($date_start=null, $date_end=null, $supplier=null)
    {
        $data = $this->model->limit(50);

        if($date_start != null && $date_start != null)
        {
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);
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

    public function TotalAmountByMonth($month=null,$year=null,$ori=null)
    {
        if($month == null)
        {
            $month = Carbon::now()->month;
            $year  = date("Y");
        }       

        $result = $this->model->whereMonth('created_at',$month)->whereYear('created_at',$year)->sum('total_amount');
        
        if($ori != 'ORIGINAL_RESULT')
        {
            return 'Rp '. number_format($result, 0, ',', '.');
        }
        else
        {
            return $result;
        }
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

}
