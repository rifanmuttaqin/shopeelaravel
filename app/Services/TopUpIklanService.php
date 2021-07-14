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
       * @return int
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
    * @return int
    */
    public function findById($id)
    {
            return $this->iklan->find($id);
    }

    // ------------------- Helper Function ------------------

}