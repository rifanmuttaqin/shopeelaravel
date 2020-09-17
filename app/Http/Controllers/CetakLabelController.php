<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Transaksi\Transaksi;

use App\Services\TransaksiService;

use Milon\Barcode\DNS1D;

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
            $date_range   = explode(" - ",$request->get('dates'));

            $date_start   = date('Y-m-d',strtotime($date_range[0]));
            $date_end     = date('Y-m-d',strtotime($date_range[1]));

            $this->transaksi = new TransaksiService();

            $data  = $this->transaksi->getAll($date_start, $date_end, $request->get('type_cetak'));

            $this->changeStatus($data);

            $pdf   = PDF::loadView('cetak-label.label-pdf',['data'=> $data])->setPaper('a4', 'portrait');
            
            return $pdf->download('cetak_label.pdf');
        }
    }

    /**
     * Rubah Status Ke Sudah Cetak
     */
    private function changeStatus($data)
    {
        foreach ($data as $transaksi) 
        {
            $data_transaksi = Transaksi::findOrFail($transaksi->id);
            $data_transaksi->status_cetak = Transaksi::SUDAH_CETAK;

            $data_transaksi->save();
        }

        return true;
    }

}
