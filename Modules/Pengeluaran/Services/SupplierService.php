<?php

namespace Modules\Pengeluaran\Services;

use Illuminate\Support\Facades\DB;
use Modules\Pengeluaran\Entities\Supplier\Supplier;

class SupplierService {

      protected $supplier;

      public function __construct(Supplier $supplier)
      {
            $this->supplier = $supplier;
      }

      /**
       * @return
      */
      public function getBySupplierName($param)
      {
            return $this->supplier->where('nama', $param)->first();
      }

      /**
       * @return
      */
      public function getAll($search = null)
      {
            return $this->supplier->where('nama', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
      }

      /**
       * @return
      */
      public function findById($id)
      {
            return $this->supplier->findOrFail($id);
      }
}