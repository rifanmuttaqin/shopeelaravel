<?php

namespace App\Services;

use App\Model\Iklan\Iklan;


class TopUpIklanService {

	protected $iklan;

	public function __construct(Iklan $iklan)
	{
	    $this->iklan = $iklan;
      }

    /**
    * @return int
    */
    public function getAll($search = null)
    {
        return $this->iklan->where('total_iklan', 'like', '%'.$search.'%')->get();
    }

    // ------------------- Helper Function ------------------

}