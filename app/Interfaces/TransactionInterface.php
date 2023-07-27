<?php

namespace App\Interfaces;

interface TransactionInterface extends BaseInterface
{
    public function getTransaksi();
    public function getByYear($tahun);
    public function TotalPaketByMonth($month=null,$year=null);
    public function notPrint();
    public function getTotalTransaksi();
    public function getBestCustomer();
    public function findByNoPesanan($param);
    public function checkIfExist($no_pesanan);
    public function getAll($date_start=null, $date_end=null, $type_cetak=null, $customers=null, $toko=null, $search=null,$transaksi_id=null);
    public function getTotalIncomeByFilter($date_start=null, $date_end=null, $type_cetak, $customer=null, $toko=null, $ori=null);
    public function getTotalIncome($ori=null);
    public function countCustomer($param);
    public function countTotalData();
    public function productExplode($product);
}
