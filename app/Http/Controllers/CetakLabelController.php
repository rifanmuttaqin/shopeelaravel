<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Transaksi\Transaksi;

use App\Services\TransaksiService;

use PDF;

class CetakLabelController extends Controller
{
    private $transaksi;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application cetak-label.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('cetak-label.index', ['active'=>'cetak-label', 'title'=>'Cetak Label Pengiriman']);   
    }

     /**
     * 
     */
    public function doCetak(Request $request)
    {
        if($request->dates != null)
        {
            $this->transaksi = new TransaksiService();

            $data   = $this->transaksi->getAll();
            
            $pdf    = PDF::loadView('cetak-label.label-pdf', 
            [
                'data'       => $data
            ]
            )->setPaper('a5', 'portrait');
            
            return $pdf->download('cetak_label.pdf');
        }
    }

}
