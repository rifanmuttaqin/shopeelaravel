<?php

namespace App\Imports\UpdateUser;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UpdateUserImport implements ToCollection, WithStartRow
{
      public $result;
      public $customer_service;
  
      public function __construct($customer_service)
      {
            $this->customer_service   = $customer_service;
      }


      /**
       * @return int
      */
      public function startRow(): int
      {
            return 2;
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
                  $customer = $this->customer_service->getByUserName($row[40]);

                  if($customer)
                  {
                        $customer->telfon_pembeli     = $row[42];
                        $customer->alamat_pembeli     = $row[43];
                        $customer->kota_pembeli       = $row[44];
                        $customer->provinsi_pembeli   = $row[45];

                        if($customer->save())
                        {
                              $finish_job = true;
                        }
                  }
            }

            if($finish_job)
            {
                  DB::commit();
            }

            $this->result = $finish_job;
      }

}