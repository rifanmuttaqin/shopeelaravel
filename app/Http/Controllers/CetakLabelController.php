<?php

namespace App\Http\Controllers;

use App\Model\HistoryCetak\HistoryCetak;
use Illuminate\Http\Request;
use App\Model\Transaksi\Transaksi;
use App\Services\HistoryCetakService;
use App\Services\TransaksiService;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use App\Services\SettingService;
use Barryvdh\DomPDF\Facade as PDF;

class CetakLabelController extends Controller
{
    private $transaksi;
    private $setting;
    private $history_cetak;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransaksiService $transaksi, SettingService $setting, HistoryCetakService $history_cetak)
    {
            $this->middleware('auth');
            $this->transaksi = $transaksi;
            $this->setting = $setting;
            $this->history_cetak = $history_cetak;
    }

    /**
     * Show the application cetak-label.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('cetak-label.index', ['active'=>'cetak-label', 'title'=>'Cetak Kartu Ucapan Pengiriman']);   
    }

    /**
     * General Cetak By Laporan
     */
    public function doCetak(Request $request)
    {
        return $this->cetakPdf($request)->stream('cetak_label.pdf');       
    }

    /**
     * Cetak By History
     */
    public function cetakByHistory($id=null)
    {
        $request = [];
        $data = HistoryCetak::findOrFail($id);

        if($data != null)
        {
            $request = [
                  'dates'=> $data->date_range,
                  'type_cetak'=>'SEMUA',
                  'toko'=>$data->user_toko_id,
                  'customer'=>isset($data->array_user) ? explode("|",$data->array_user) : null
            ];

            return $this->cetakPdf((object) $request, 'TYPE_HISTORY')->stream('cetak_label.pdf'); 
        }
    }

    private function cetakPdf($request, $type=null)
    {
        if($request->dates != null)
        {
                  $date_range   = explode(" - ",$request->dates);

                  $date_start   = date('Y-m-d',strtotime($date_range[0]));
                  $date_end     = date('Y-m-d',strtotime($date_range[1]));
                  $setting      = $this->setting;

                  $toko         = $request->toko;
                  $data         = $this->transaksi->getAll($date_start, $date_end, $request->type_cetak, $request->customer, $toko)->get();

                  if($type == null && $type != 'TYPE_HISTORY')
                  {
                        $this->history_cetak->logIntoHistory($request,$data);
                  }

                  $this->changeStatus($data);

                  $pdf   = PDF::loadView('cetak-label.label-pdf',['data'=> $data, 'setting'=>$setting])->setPaper($setting->getSetting()->paper_size, 'portrait');

                  return $pdf;
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
       * Preview List Preview Preview 
       */
      public function preview(Request $request)
      {
                  if($request->ajax())
                  {           
                        $toko       = $request->get('toko');
                  
                        $date_start = null;
                        $date_end   = null;

                        if($request->get('dates'))
                        {
                              $date_range   = explode(" - ",$request->get('dates'));
                              $date_start   = date('Y-m-d',strtotime($date_range[0]));
                              $date_end     = date('Y-m-d',strtotime($date_range[1]));
                        }
                  
                        $data            = new Collection();
                        $transaksi       = $this->transaksi->getAll($date_start, $date_end, $request->get('type_cetak'), $request->get('customer'), $toko)->get();

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
