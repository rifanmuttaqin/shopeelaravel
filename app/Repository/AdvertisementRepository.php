<?php

namespace App\Repository;

use App\Interfaces\AdvertisementInterface;
use App\Model\Iklan\Iklan as Advertisement;
use Carbon\Carbon;

class AdvertisementRepository implements AdvertisementInterface
{
    private $model;

    public function __construct(Advertisement $advertisement)
    {
        $this->model   = $advertisement;
    }

    public function getAll($search = null,$date_start=null, $date_end=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->model->where('total_iklan', 'like', '%'.$search.'%')->orderBy('created_at','DESC');

        if($date_start != null && $date_end != null)
        {
            $data = $data->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);
        }

        return $data->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getTotal($ori=null)
    {
        $result = $this->model->whereMonth('date', '=', date('m'))->whereYear('date',date("Y"))->sum('total_iklan');

        if($ori == 'ORIGINAL_RESULT')
        {
            return $result;
        }
        else
        {
            return number_format($result,0,",",".");
        }
    }


    public function getTotalByFilter($date_start=null, $date_end=null, $toko=null, $ori=null)
    {
        $date_from  = Carbon::parse($date_start)->startOfDay();
        $date_to    = Carbon::parse($date_end)->endOfDay();

        $data = $this->model->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);

        if($toko != null)
        {
                $data = $data->where('user_toko_id', $toko);
        }

        if($ori === 'ORIGINAL_RESULT')
        {
            return $data->sum('total_iklan');
        }
        else
        {
            return number_format($data->sum('total_iklan'),0,",",".");
        }            
    }


}