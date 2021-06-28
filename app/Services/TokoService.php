<?php

namespace App\Services;

use App\Model\Toko\Toko;

class TokoService {

	protected $toko;

	public function __construct(Toko $toko)
	{
	    $this->toko = $toko;
      }

    /**
    * @return int
    */
    public function getAll($search = null)
    {
        return $this->toko->where('nama_toko', 'like', '%'.$search.'%')->get();
    }

    /**
    * @return int
    */
    public function findTokoByName($nama_toko)
    {
        return $this->toko->where('nama_toko', $nama_toko)->first();
    }


    // ------------------- Helper Function ------------------

}