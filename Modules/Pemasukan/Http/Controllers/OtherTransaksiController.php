<?php

namespace Modules\Pemasukan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;
use Modules\Pemasukan\Http\Requests\Transaksi\StoreTransaksiOtherRequest;
use Modules\Pemasukan\Services\CustomerOfflineService;
use Modules\Pemasukan\Services\TransaksiOfflineService;

class OtherTransaksiController extends Controller
{
    public $customer_service;
    public $transaksi_service;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerOfflineService $customer_service, TransaksiOfflineService $transaksi_service)
    {
        $this->middleware('auth');
        $this->customer_service = $customer_service;
        $this->transaksi_service = $transaksi_service;
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('pemasukan::transaksi.other',['active'=>'transaksi-other', 'title'=> 'Transaksi']);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreTransaksiOtherRequest $request)
    {
        DB::beginTransaction();

        try {
            
            TransaksiOffline::create(array_merge($request->all(),[
                'nama_customer' => $this->customer_service->findById($request->get('nama_customer'))->nama,
                'invoice_code' => $this->transaksi_service->generateInvoiceCode(),
            ]));

            DB::commit();
            return redirect('pemasukan/transaksi-offline-other')->with('alert_success', 'Transaksi Anda Berhasil Disimpan');

        } catch (\Throwable $th) {
            return redirect('pemasukan/transaksi-offline-other')->with('alert_error', 'Transaksi Anda Gagal Disimpan');
        }

    }

}
