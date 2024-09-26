<?php

namespace App\Imports\Shopeepay;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class ShopeepayImport implements ToCollection, WithStartRow
{
      public     $result;
      protected  $transaksi_service;
      public     $file_name;

      public function __construct($file_name, $transaksi_service)
      {
            $this->transaksi_service  = $transaksi_service;
            $this->file_name          = $file_name;
      }

      /**
       * @return int
      */
      public function startRow(): int
      {
            return 19;
      }

      /**
       * @return int
      */
      public function collection(Collection $rows)
      {
            DB::beginTransaction();
            $finish_job = false;
            foreach ($rows as $row)
            {
                  $no_pesanan = $row[3];
                  $transaksi  = $this->transaksi_service->findByNoPesanan($no_pesanan);

                  if($transaksi != null)
                  {
                        $transaksi->pendapatan_bersih = (int)$row[5];
                        if(!$transaksi->save()) {
                              $finish_job = false;
                              break;
                        }
                        else {
                              $finish_job = true;
                        }
                  }
                  else {
                        $finish_job = true;
                  }
            }

            if($finish_job) {
                  DB::commit();
            }

            $this->result = $finish_job;
      }
}
