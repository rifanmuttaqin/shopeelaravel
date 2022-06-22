<?php

namespace App\Services;

use App\Model\Ekspedisi\Ekspedisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EkspedisiService {

    protected $ekspedisi;

    public function __construct(Ekspedisi $ekspedisi)
    {
        $this->ekspedisi = $ekspedisi;
    }

    /**
     * @return
     */
    public function getAll($search = null)
    {
        $data = $this->ekspedisi->select('tbl_ekspedisi.*')->where('tbl_ekspedisi.ekspedisi_name', 'like', '%'.$search.'%');    
        return $data;
    }
}