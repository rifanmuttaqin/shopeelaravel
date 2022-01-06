<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pemasukan\Services\CustomerOfflineService;

class CetakOfflineController extends Controller
{
    private $customer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerOfflineService $customer)
    {
        $this->middleware('auth');
        $this->customer = $customer;
    }

    /**
     * Show the application cetak-label.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('cetak-label-offline.index', ['active'=>'cetak-label-offline', 'title'=>'Ucapan Pengiriman Custom Nama']);   
    }

}
