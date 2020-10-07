<?php

namespace App\Imports\Shopeepay;

use App\Model\User\User;
use App\Model\Transaksi\Transaksi;
use App\Model\Customer\Customer;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Maatwebsite\Excel\Concerns\ToModel;

use App\Services\TransaksiService;

use Auth;

use DB;

class ShopeepayImport implements ToCollection, WithStartRow
{
  	public     $result;
    protected  $transaksi_service; 
    public     $file_name;

    public function __construct($file_name)
    {
      $this->transaksi_service  = new TransaksiService();
      $this->file_name          = $file_name;
    }


    /**
    * @return int
    */
    public function startRow(): int
    {
      return 8;
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
            $no_pesanan = $this->getNo_pesanan($row[3]);
            $transaksi  = TransaksiService::findByNoPesanan($no_pesanan);

            if($transaksi != null)
            {
                $transaksi->pendapatan_bersih = $row[2];
                
                if(!$transaksi->save())
                {
                    $finish_job = false;
                    break;
                }
                else
                {
                    $finish_job = true;
                }
            }
            else
            {
                $finish_job = true; 
            }           
        }
      
        if($finish_job)
        {
          DB::commit();
        }
           
        $this->result = $finish_job;
    }


    /**
    * @return string
    */
    private function getNo_pesanan($param)
    {
      $param =  (explode("#",$param)); 
      $param =  $param[1];

      return $param;
    }


}