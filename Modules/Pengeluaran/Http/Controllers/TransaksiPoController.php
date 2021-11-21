<?php

namespace Modules\Pengeluaran\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;
use Modules\Pengeluaran\Http\Requests\TransaksiPo\StoreTransaksiPoRequest;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPoDetail;

class TransaksiPoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('pengeluaran::transaksi_po.index',['active'=>'transaksi-po', 'title'=> 'Input data pengeluaran']);
    }

    public function addchart(Request $request)
    {
        if($request->ajax())
        {
            $produk = new Collection();
            $total_amount = 0;

            if($request->get('array_chart') != null)
            {
                foreach ($request->get('array_chart') as $chart) {
                    $data_obj = json_decode($chart);
                    $produk->push([
                        'nama_produk'=> $data_obj->nama_produk,
                        'total_price'=> $data_obj->total_price,
                        'qty'=> $data_obj->qty,
                        'total'=> $data_obj->total_price * $data_obj->qty,
                    ]);

                    $total_amount += $data_obj->total_price * $data_obj->qty;
                }
            }
            return View::make('pengeluaran::transaksi_po.render-table', ['produk'=>$produk->toArray(),'active'=>'transaksi-po', 'title'=> 'Input data pengeluaran','total_amount'=>$total_amount]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreTransaksiPoRequest $request)
    {
        DB::beginTransaction();

        $main_transaksi = new TransaksiPo($request->all());
        $main_transaksi->status_aktif = true;        
        $main_transaksi->nota         = $this->imageUpload($request);

        if($main_transaksi->save()) {

            if($request->get('produk_chart') != []){

                $flag_detail =false;

                $produks = json_decode('['.$request->get('produk_chart').']');              

                foreach ($produks as $product) {

                    $detail_transaksi = new TransaksiPoDetail();
                    $detail_transaksi->id_transaksi_po = $main_transaksi->id;
                    $detail_transaksi->nama_produk = $product->nama_produk;
                    $detail_transaksi->harga_produk = $product->total_price;
                    $detail_transaksi->qty_beli = $product->qty;
                    $detail_transaksi->status_aktif = true;

                    if($detail_transaksi->save()){
                        $flag_detail = true;
                    }
                    else{
                        $flag_detail = false;
                    }
                }

                if($flag_detail)
                {
                    DB::commit();
                    return redirect('pengeluaran/transaksi-po')->with('alert_success', 'Transaksi Anda Berhasil Disimpan');
                }
                else
                {
                    DB::rollback();
                    return redirect('pengeluaran/transaksi-po')->with('alert_error', 'Transaksi Anda Gagal Disimpan');
                }
            }            
        }
    }   

    private function imageUpload($request)
    {
        $nota       = $request->file('nota');
        $fileName   = time() . '.' . $nota->getClientOriginalExtension();

        $img = Image::make($nota->getRealPath());
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();                 
        });

        $img->stream();
        Storage::disk('local')->put('public/'.$fileName, $img, 'public');

        return $fileName;
    }

}
