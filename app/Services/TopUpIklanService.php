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

    /**
    * @return int
    */
    public function findById($id)
    {
            return $this->iklan->find($id);
    }

    // ------------------- Helper Function ------------------

}