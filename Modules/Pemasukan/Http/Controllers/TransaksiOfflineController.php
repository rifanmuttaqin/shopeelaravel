<?php

namespace Modules\Pemasukan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOfflineDetail;
use Modules\Pemasukan\Http\Requests\Transaksi\StoreTransaksiOfflineRequest;
use Modules\Pemasukan\Services\CustomerOfflineService;
use Modules\Pemasukan\Services\ProdukService;
use Modules\Pemasukan\Services\TransaksiOfflineService;

class TransaksiOfflineController extends Controller
{
    public $produk_service;
    private $total_amount;
    public $customer_service;
    public $transaksi_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProdukService $produk, CustomerOfflineService $customer_service, TransaksiOfflineService $transaksi)
    {
        $this->middleware('auth');
        $this->produk_service = $produk;
        $this->customer_service = $customer_service;
        $this->transaksi_service = $transaksi;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('pemasukan::transaksi.index',['active'=>'transaksi-offline', 'title'=> 'Transaksi Penjualan Luar MarketPlace']);
    }

    public function addchart(Request $request)
    {
        if($request->ajax())
        {
            $produk      = new Collection();

            if($request->get('array_chart') != null)
            {
                foreach ($request->get('array_chart') as $chart) {
                    
                    $data_obj   = json_decode($chart);
                    $produk     = $this->getProdukInfo($produk,$data_obj);
                }
            }

            // --- Reuse modul pengeluaran Transaksi utuk preview tabel
            return View::make('pengeluaran::transaksi_po.render-table', ['produk'=>$produk->toArray(),'active'=>'transaksi-po', 'title'=> 'Transaksi Offline','total_amount'=>$this->total_amount]);
        }
    }


    private function getProdukInfo($produk,$data_obj)
    {
        $produk_data = $this->produk_service->findById($data_obj->id_produk);

        $status = 'normal_price';

        if($produk_data->is_grosir)
        {
            if($data_obj->qty >= $produk_data->minimal_pengambilan_satu && $data_obj->qty < $produk_data->minimal_pengambilan_dua)
            {
                $status = 'tingkat_satu';
            }
            
            if($produk_data->minimal_pengambilan_dua != null)
            {
                if($data_obj->qty >= $produk_data->minimal_pengambilan_dua)
                {
                    $status = 'tingkat_dua';
                }
            }
        }

        switch ($status) {
            
            case 'normal_price':

                $produk->push([
                    'nama_produk'=> $produk_data->nama_produk,
                    'total_price'=> $produk_data->harga,
                    'qty'=> $data_obj->qty,
                    'total'=> $produk_data->harga * $data_obj->qty,
                ]);

                $this->total_amount += $produk_data->harga * $data_obj->qty;

                return $produk;
            
            case 'tingkat_satu':
                $produk->push([
                    'nama_produk'=> $produk_data->nama_produk,
                    'total_price'=> $produk_data->harga_grosir_satu,
                    'qty'=> $data_obj->qty,
                    'total'=> $produk_data->harga_grosir_satu * $data_obj->qty,
                ]);

                $this->total_amount += $produk_data->harga_grosir_satu * $data_obj->qty;
                
                return $produk;

            case 'tingkat_dua':
                $produk->push([
                    'nama_produk'=> $produk_data->nama_produk,
                    'total_price'=> $produk_data->harga_grosir_dua,
                    'qty'=> $data_obj->qty,
                    'total'=> $produk_data->harga_grosir_dua * $data_obj->qty,
                ]);
                
                $this->total_amount += $produk_data->harga_grosir_dua * $data_obj->qty;

                return $produk;        

            default:
                $produk->push([
                    'nama_produk'=> $produk_data->nama_produk,
                    'total_price'=> $produk_data->harga,
                    'qty'=> $data_obj->qty,
                    'total'=> $produk_data->harga * $data_obj->qty,
                ]);
                
                $this->total_amount += $produk_data->harga * $data_obj->qty;

                return $produk;
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreTransaksiOfflineRequest $request)
    {
        DB::beginTransaction();

        $main_transaksi = new TransaksiOffline($request->all());
        $main_transaksi->nama_customer = $this->customer_service->findById($request->get('nama_customer'))->nama;
        $main_transaksi->invoice_code = $this->transaksi_service->generateInvoiceCode();       

        if($main_transaksi->save()) {

            if($request->get('produk_chart') != []){

                $flag_detail =false;

                $produks = json_decode('['.$request->get('produk_chart').']'); 
                
                foreach ($produks as $product) {

                    $detail_transaksi = new TransaksiOfflineDetail();
                    $detail_transaksi->id_transaksi = $main_transaksi->id;
                    $detail_transaksi->nama_produk = $this->produk_service->findById($product->id_produk)->nama_produk;
                    $detail_transaksi->harga_produk = $this->getPriceProduk($this->produk_service->findById($product->id_produk),$product->qty);
                    $detail_transaksi->qty_beli = $product->qty;
                    
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
                    return redirect('pemasukan/transaksi-offline')->with('alert_success', 'Transaksi Anda Berhasil Disimpan');
                }
                else
                {
                    DB::rollback();
                    return redirect('pemasukan/transaksi-offline')->with('alert_error', 'Transaksi Anda Gagal Disimpan');
                }
            }            
        }
    }

    private function getPriceProduk($obj_produk, $qty_order)
    {
        $harga = $obj_produk->harga;
        
        if($obj_produk->is_grosir)
        {
            if($qty_order >= $obj_produk->minimal_pengambilan_satu && $qty_order < $obj_produk->minimal_pengambilan_dua)
            {
                return $obj_produk->harga_grosir_satu;
            }
            else if($qty_order >= $obj_produk->minimal_pengambilan_dua)
            {
                if($obj_produk->minimal_pengambilan_dua == null)
                {
                    return $obj_produk->harga_grosir_satu;
                }

                return $obj_produk->harga_grosir_dua;
            }
        }

        return $harga;
    }

}
