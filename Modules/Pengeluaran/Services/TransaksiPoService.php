<?php

namespace Modules\Pengeluaran\Services;

use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;

class TransaksiPoService {

    protected $transaksi;

    public function __construct(TransaksiPo $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * @return
     */
    public function getAll()
    {
        return $this->transaksi->limit(50)->orderBy('created_at', 'DESC');
    }

    /**
     * @return
     */
    public function findById($id)
    {
        return $this->transaksi->findOrFail($id);
    }

    public function getDetail($id)
    {
        return $this->findById($id)->detail;
    }

}