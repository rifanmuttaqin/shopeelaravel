<?php

namespace App\Imports\Transaksi;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use App\Model\Transaksi\Transaksi;
use App\Model\Customer\Customer;


class TransaksiImport implements ToCollection, WithStartRow
{
      public $result;
      public $toko_name;
      public $transaksi_service;
      public $customer_service;
      public $toko_service;
  
      public function __construct($toko_name, $transaksi_service, $toko_service, $customer_service)
      {
            $this->toko_name          = $toko_name;
            $this->transaksi_service  = $transaksi_service;
            $this->customer_service   = $customer_service;
            $this->toko_service       = $toko_service;
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
            if($this->transaksi_service->checkIfExist($row[1]))
            {
                  DB::rollBack();
                  $finish_job = false;
                  break;
            }

            $toko      = $this->toko_service->findTokoByName($this->toko_name);

            $transaksi = new Transaksi();

            $transaksi->user_created				 =    Auth::user()->id;
            $transaksi->no_resi					 =	$row[0];
            $transaksi->no_pesanan				       =	$row[1];
            $transaksi->tgl_pesanan_dibuat	             =	$row[2];
            $transaksi->status_pesanan			       =	$row[3];
            $transaksi->status_pembatalan	                   =	$row[4];
            $transaksi->deadline_pengiriman                  =	$row[6] != null ? $row[6] : date("Y-m-d");
            $transaksi->produk					 =	$row[7];
            $transaksi->jasa_kirim				       =	$row[8];
            $transaksi->username_pembeli		             =	$row[5];
            $transaksi->nama_pembeli				 =	$row[9];
            $transaksi->user_toko_id                         =    $toko != null ? $toko->id : null;
            $transaksi->status_cetak				 =	Transaksi::BELUM_CETAK;
            $transaksi->status_aktif                         =    true;

            if(!$transaksi->save())
            {
                  DB::rollBack();
                  $finish_job = false;
            }
            else
            {
                  if(!$this->customer_service->checkIfExist($transaksi->username_pembeli))
                  {
                        $customer = new Customer();
                        $customer->telfon_pembeli     = 'UNDEFINED';
                        $customer->alamat_pembeli     = 'UNDEFINED';
                        $customer->kota_pembeli       = 'UNDEFINED';
                        $customer->provinsi_pembeli   = 'UNDEFINED';
                        $customer->kode_pos_pembeli   = 'UNDEFINED';
                  }
                  else
                  {
                        $customer = $this->customer_service->getByUserName($transaksi->username_pembeli);
                        $customer->telfon_pembeli     = $customer->telfon_pembeli;
                        $customer->alamat_pembeli     = $customer->alamat_pembeli;
                        $customer->kota_pembeli       = $customer->kota_pembeli;
                        $customer->provinsi_pembeli   = $customer->provinsi_pembeli;
                        $customer->kode_pos_pembeli   = $customer->kode_pos_pembeli;
                  }

                  $customer->username_pembeli   = $transaksi->username_pembeli;
                  $customer->nama_pembeli       = $transaksi->nama_pembeli;
                  $customer->user_created       = Auth::user()->id;
                  $customer->status_aktif       = true;

                  if(!$customer->save())
                  {
                        DB::rollBack();
                        $finish_job = false;
                  }  

                  $finish_job = true;
            }

            }

            if($finish_job)
            {
                  DB::commit();
            }

            $this->result = $finish_job;
    }

}