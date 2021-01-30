<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Transaksi\Transaksi;

use App\Model\Customer\Customer;

use App\Services\TransaksiService;


use Yajra\Datatables\Datatables;

use Milon\Barcode\DNS1D;

use Illuminate\Support\Collection;

use PDF;

class CetakLabelController extends Controller
{
    private $transaksi;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi)
    {
        $this->middleware('auth');
        $this->transaksi = $transaksi;
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

            $toko         = $request->get('toko');

            $data         = $this->transaksi->getAll($date_start, $date_end, $request->get('type_cetak'), $request->get('customer'), $toko);

            $this->changeStatus($data);

            $pdf   = PDF::loadView('cetak-label.label-pdf',['data'=> $data])->setPaper('A6', 'portrait');
            
            return $pdf->stream('cetak_label.pdf');
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

    /**
     * Preview List 
     */
    public function preview(Request $request)
    {
        if($request->ajax())
        {           
            $type_cetak = $request->get('type_cetak');
            $toko       = $request->get('toko');
            $customer   = $request->get('customer');

            $date_start = null;
            $date_end   = null;

            if($request->get('dates'))
            {
                $date_range   = explode(" - ",$request->get('dates'));
                $date_start   = date('Y-m-d',strtotime($date_range[0]));
                $date_end     = date('Y-m-d',strtotime($date_range[1]));
            }
           
            $data            = new Collection();
            $transaksi       = $this->transaksi->getAll($date_start, $date_end, $request->get('type_cetak'), $request->get('customer'), $toko);

            foreach ($transaksi as $transaksi_data) 
            {
                $data->push([
                    'id'                 => $transaksi_data->id,
                    'no_resi'            => $transaksi_data->no_resi,
                    'username_pembeli'   => $transaksi_data->username_pembeli,
                    'nama_pembeli'       => $transaksi_data->nama_pembeli,
                    'produk'             => $transaksi_data->produk,
                    'status_cetak'       => $transaksi_data->status_cetak,
                    'tgl_pesanan_dibuat' => $transaksi_data->tgl_pesanan_dibuat,
                    'pendapatan_bersih'  => $transaksi_data->pendapatan_bersih,
                    'catatan_order'      => $transaksi_data->catatan_order,
                ]);
            }   

            return Datatables::of($data)
            ->addColumn('status_cetak', function($row){  
                    
                    if(Transaksi::findOrFail($row['id'])->status_cetak != Transaksi::BELUM_CETAK)
                    {
                        return 'SUDAH';
                    }
                    else
                    {
                        return 'BELUM';
                    }

            })

            ->make(true);          
        }
    }

}
