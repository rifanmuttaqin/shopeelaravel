<?php

namespace App\Services;

use App\Model\Iklan\Iklan;

use Carbon\Carbon;

class TopUpIklanService {

	protected $iklan;

	public function __construct(Iklan $iklan)
	{
	    $this->iklan = $iklan;
      }

      /**
       * @return
      */
      public function getAll($search = null,$date_start=null, $date_end=null)
      {
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data = $this->iklan->where('total_iklan', 'like', '%'.$search.'%')->orderBy('date','ASC');

            if($date_start != null && $date_end != null)
            {
                  $data = $data->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);
            }

            return $data->get();
      }

      /**
       * @return
      */
      public function findById($id)
      {
            return $this->iklan->find($id);
      }


      public function getTotalByFilter($date_start=null, $date_end=null, $toko=null, $ori=null)
      {
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data = $this->iklan->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to);
          
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

    // ------------------- Helper Function ------------------

}