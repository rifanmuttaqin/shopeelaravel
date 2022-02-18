<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;
use Modules\Pemasukan\Services\CustomerOfflineService;
use Barryvdh\DomPDF\Facade as PDF;

class CetakOfflineController extends Controller
{
    private $customer;
    private $setting;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerOfflineService $customer, SettingService $setting)
    {
        $this->middleware('auth');
        $this->customer = $customer;
        $this->setting = $setting;
    }
 
    /**
     * Show the application cetak-label.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('cetak-label-offline.index', ['active'=>'cetak-label', 'title'=>'Ucapan Pengiriman']);   
    }

    public function doCetak(Request $request){
        return $this->cetakPdf($request)->stream('cetak_label.pdf');    
    }

    private function cetakPdf($request){
        $pdf   = PDF::loadView('cetak-label-offline.label-pdf',['data'=>$request,'setting'=>$this->setting])->setPaper($this->setting->getSetting()->paper_size, 'portrait');
        return $pdf;
    }

}
