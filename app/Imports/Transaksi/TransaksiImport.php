<?php

namespace App\Imports\Transaksi;

use App\Model\User\User;
use App\Model\Transaksi\Transaksi;
use App\Model\Customer\Customer;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

use Auth;

use DB;

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

          $transaksi->user_created				 =  Auth::user()->id;
          $transaksi->no_resi					     =	$row[0];
          $transaksi->no_pesanan				   =	$row[1];
          $transaksi->tgl_pesanan_dibuat	 =	$row[2];
          $transaksi->status_pesanan			 =	$row[3];
          $transaksi->status_pembatalan	   =	$row[4];
          $transaksi->deadline_pengiriman  =	$row[7];
          $transaksi->produk					     =	$row[8];
          $transaksi->jasa_kirim				   =	$row[9];
          $transaksi->username_pembeli		 =	$row[5];
          $transaksi->nama_pembeli				 =	$row[10];
          $transaksi->telfon_pembeli			 =	$row[11];
          $transaksi->alamat_pembeli			 =	$row[12];
          $transaksi->kota_pembeli				 =	$row[13];
          $transaksi->provinsi_pembeli		  =	$row[14];
          $transaksi->kode_pos_pembeli			=	$row[15];
          $transaksi->user_toko_id          = $toko != null ? $toko->id : null;
          $transaksi->status_cetak				  =	Transaksi::BELUM_CETAK;

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
            }
            else
            {
              $customer = $this->customer_service->getByUserName($transaksi->username_pembeli);
            }

            $customer->username_pembeli   = $transaksi->username_pembeli;
            $customer->nama_pembeli       = $transaksi->nama_pembeli;
            $customer->telfon_pembeli     = $transaksi->telfon_pembeli;
            $customer->alamat_pembeli     = $transaksi->alamat_pembeli;
            $customer->kota_pembeli       = $transaksi->kota_pembeli;
            $customer->provinsi_pembeli   = $transaksi->provinsi_pembeli;
            $customer->kode_pos_pembeli   = $transaksi->kode_pos_pembeli;
            $customer->user_created       = Auth::user()->id;

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