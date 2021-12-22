<?php

namespace Modules\Pemasukan\Services;

use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\Produk\Produk;

class ProdukService {

    protected $produk;

    public function __construct(Produk $produk)
    {
        $this->produk = $produk;
    }

    /**
     * @return
     */
    public function getByProductName($param)
    {
        return $this->produk->where('nama_produk', $param)->first();
    }

    /**
     * @return
     */
    public function getAll($search = null)
    {
        return $this->produk->where('nama_produk', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
    }

    /**
     * @return
     */
    public function findById($id)
    {
        return $this->produk->findOrFail($id);
    }

}