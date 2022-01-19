<?php

namespace Modules\Pemasukan\Services;

use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOfflineDetail;

class TransaksiOfflineDetailService {

    protected $transaksi;

    public function __construct(TransaksiOfflineDetail $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function getDetail($transaksi_id)
    {
        return $this->transaksi->where('id_transaksi', $transaksi_id);
    }

}