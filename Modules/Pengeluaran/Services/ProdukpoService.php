<?php

namespace Modules\Pengeluaran\Services;

use Illuminate\Support\Facades\DB;
use Modules\Pengeluaran\Entities\Produkpo\Produkpo;

class ProdukpoService {

      protected $produk_po;

      public function __construct(Produkpo $produk_po)
      {
            $this->produk_po = $produk_po;
      }

     
      /**
       * @return
      */
      public function getByProductName($param)
      {
            return $this->produk_po->where('nama_produk', $param)->first();
      }

      /**
       * @return
      */
      public function getAll($search = null)
      {
            return $this->produk_po->orderBy('created_at', 'DESC');
      }

      /**
       * @return
      */
      public function findById($id)
      {
            return $this->produk_po->findOrFail($id);
      }


}