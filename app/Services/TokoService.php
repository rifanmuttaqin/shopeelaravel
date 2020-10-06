<?php

namespace App\Services;

use App\Model\Toko\Toko;

use Auth;

class TokoService {

	protected $toko;

	public function __construct()
	{
	    $this->toko = new Toko();
    }

    /**
    * @return int
    */
    public static function getAll($search = null)
    {
        $data = Toko::where('nama_toko', 'like', '%'.$search.'%')->where('user_id', Auth::user()->id)->get();
        return $data;
    }

    /**
    * @return int
    */
    public static function findTokoByName($nama_toko)
    {
        return Toko::where('nama_toko', $nama_toko)->first();
    }

}