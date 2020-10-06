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
        $data = Toko::where('nama_toko', $nama_toko)->first();
        
        if($data == null)
        {
            $data = $this->createToko($nama_toko);
        }

        return $data;
    }


    // ------------------- Helper Function -------------------

    /**
    * @return int
    */
    private function createToko($nama_toko)
    {
        $toko_model                 = $this->toko;
        $toko_model->user_id        = Auth::user()->id;
        $toko_model->nama_toko      = $nama_toko;
        $toko_model->alamat_toko    = '-';
        $toko_model->link_shopee    = 'shopee.co.id/'.$nama_toko;

        if($toko_model->save())
        {
            return $toko_model;
        }

        return null;
    }

}