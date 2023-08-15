<?php

namespace App\Http\Controllers;

use App\Services\TopUpIklanService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\Pemasukan\Services\TransaksiOfflineService;
use Modules\Pengeluaran\Services\TransaksiPoService;

class LabarugiController extends Controller
{
    private $shopee_transaksi;
    private $po_transaksi;
    private $transaksi_non_shopee;
    private $iklan_service;

    public function __construct(TransaksiService $shopee_transaksi, TransaksiPoService $po_transaksi, TransaksiOfflineService $transaksi_non_shopee, TopUpIklanService $iklan_service)
    {
        $this->shopee_transaksi = $shopee_transaksi;
        $this->po_transaksi = $po_transaksi;
        $this->transaksi_non_shopee = $transaksi_non_shopee;
        $this->iklan_service = $iklan_service;
        $this->middleware('auth');
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('laba-rugi.index', ['active'=>'laba-rugi', 'title'=>'Laporan Laba Rugi']);   
    }

    public function preview(Request $request)
    {
        if($request->ajax())
        {
            $date_range   = explode(" - ",$request->dates);

            $date_start   = date('Y-m-d',strtotime($date_range[0]));
            $date_end     = date('Y-m-d',strtotime($date_range[1]));

            $income_shopee = $this->shopee_transaksi->getTotalIncomeByFilter($date_start, $date_end, null, null, null,'ORIGINAL_RESULT');
            $income_transaksi_non_shopee = $this->transaksi_non_shopee->getTotalIncomeByFilter($date_start, $date_end,'ORIGINAL_RESULT');            

            $outcome_transaksi_po = $this->po_transaksi->getTotalOutcomeByFilter($date_start, $date_end,'ORIGINAL_RESULT');
            $outcome_iklan = $this->iklan_service->getTotalByFilter($date_start, $date_end, null, 'ORIGINAL_RESULT');

            return View::make('laba-rugi.preview', [
                'income_shopee'=> $income_shopee,
                'income_transaksi_non_shopee' => $income_transaksi_non_shopee,
                'outcome_transaksi_po' => $outcome_transaksi_po,
                'outcome_iklan' => $outcome_iklan
            ]);       
        }
    }



}
