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
    * @return
    */
    public function getAll($search = null)
    {
        return $this->toko->where('nama_toko', 'like', '%'.$search.'%');
    }

    /**
    * @return
    */
    public function findTokoByName($nama_toko)
    {
        return $this->toko->where('nama_toko', $nama_toko)->first();
    }

    /**
    * @return
    */
    public function findById($id)
    {
            return $this->toko->find($id);
    }


    // ------------------- Helper Function ------------------

}