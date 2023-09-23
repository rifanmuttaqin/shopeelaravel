<?php

namespace Modules\Pemasukan\Http\Controllers;

use App\Services\SettingService;
use App\Interfaces\ProductInterface;
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
use Modules\Pemasukan\Services\TransaksiOfflineDetailService;
use Modules\Pemasukan\Services\TransaksiOfflineService;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class TransaksiOfflineController extends Controller
{
    public $product;
    private $total_amount;
    public $customer_service;
    public $transaksi_service;
    private $transaksi_detail_service;
    private $setting_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerOfflineService $customer_service, TransaksiOfflineService $transaksi, TransaksiOfflineDetailService $transaksi_detail_service, SettingService $setting_service, ProductInterface $product)
    {
        $this->middleware('auth');
        $this->customer_service = $customer_service;
        $this->transaksi_service = $transaksi;
        $this->transaksi_detail_service = $transaksi_detail_service;
        $this->setting_service = $setting_service;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('pemasukan::transaksi.index',['active'=>'transaksi-offline', 'title'=> 'Transaksi']);
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

    public function detail($id=null)
    {
        if($id != null)
        {
            $main_transaksi = $this->transaksi_service->findById($id);
            $transkasi_detail = $this->transaksi_detail_service->getDetail($id)->get();

            $status_transaksi = TransaksiOffline::defineStatus($main_transaksi->status_transaksi);

            return view('pemasukan::transaksi.detail',['active'=>'transaksi-offline-list', 
                'title'=> 'Rincian Transaksi Non Marketplace',
                'transkasi_detail'=>$transkasi_detail,
                'main_transaksi'=>$main_transaksi,
                'status_transaksi'=>$status_transaksi
            ]);
        }
    }


    public function listIvoice(Request $request)
    {
        if($request->ajax())
        {
            $params    = $this->transaksi_service->getAll(null,null,$request->get('search'));
            $arr_data  = array();
            $key = 0;             

            if($params != null)
            {
                foreach ($params->get() as $param) 
                {
                    $arr_data[$key]['id']   = $param->id;
                    $arr_data[$key]['text'] = $param->invoice_code;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function listTransaksi(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = $this->transaksi_service->getAll();

            return Datatables::of($data)
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })
            ->addColumn('status_transaksi', function($row){  
                return TransaksiOffline::defineStatus($row->status_transaksi);
            })
            ->addColumn('created_at', function($row){  
                return $row->created_at;
            })->make(true);
        }

        return view('pemasukan::transaksi.list',['active'=>'transaksi-offline-list', 'title'=> 'Daftar Transaksi Non Marketplace 50 Teratas']);
    }

    private function getProdukInfo($produk,$data_obj)
    {
        $produk_data = $this->product->findById($data_obj->id_produk);

        $status = 'normal_price';

        $data_obj->qty = (float)$data_obj->qty;

        if($produk_data->is_grosir)
        {           
            if($produk_data->minimal_pengambilan_dua != null)
            {
                if($data_obj->qty >= $produk_data->minimal_pengambilan_satu && $data_obj->qty < $produk_data->minimal_pengambilan_dua)
                {
                    $status = 'tingkat_satu';
                }
                else if($data_obj->qty >= $produk_data->minimal_pengambilan_dua)
                {
                    $status = 'tingkat_dua';
                }
            }
            else
            { 
                if($data_obj->qty >= $produk_data->minimal_pengambilan_satu)
                {
                    $status = 'tingkat_satu';
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

        try {

            $main_transaksi = TransaksiOffline::create(array_merge($request->all(),[
                'nama_customer' => $this->customer_service->findById($request->get('nama_customer'))->nama,
                'invoice_code' => $this->transaksi_service->generateInvoiceCode(),
            ]));

            if($request->get('produk_chart') != []){
                    
                    $produks = json_decode('['.$request->get('produk_chart').']'); 
                
                    foreach ($produks as $product) {
        
                        $detail_transaksi = new TransaksiOfflineDetail();
                        $detail_transaksi->id_transaksi = $main_transaksi->id;
                        $detail_transaksi->nama_produk = $this->product->findById($product->id_produk)->nama_produk;
                        $detail_transaksi->harga_produk = $this->getPriceProduk($this->product->findById($product->id_produk),$product->qty);
                        $detail_transaksi->qty_beli = $product->qty;
                        
                        $detail_transaksi->save();
                    }

                    DB::commit();
                    return redirect('pemasukan/transaksi-offline')->with('alert_success', 'Transaksi Anda Berhasil Disimpan');
                }
            } catch (\Throwable $th) {
                dd($th);
                DB::rollback();
                return redirect('pemasukan/transaksi-offline')->with('alert_error', 'Transaksi Anda Gagal Disimpan '.$th);
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


    public function delete($id=null)
    {
        if($id != null)
        {
            $main_transaksi = $this->transaksi_service->findById($id);
            $transkasi_detail = $this->transaksi_detail_service->getDetail($id)->get();

            return view('pemasukan::transaksi.delete',['active'=>'transaksi-offline', 'title'=> 'Hapus Transaksi untuk '.$main_transaksi->nama_customer,'main_transaksi'=>$main_transaksi, 'transkasi_detail'=>$transkasi_detail]);
        }   
    }

    public function printFaktur($id=null)
    {
        if($id != null)
        {
            $pdf   = PDF::loadView('pemasukan::transaksi.preview-faktur',[
                'main_transaksi' => $this->transaksi_service->findById($id),
                'transkasi_detail' => $this->transaksi_detail_service->getDetail($id)->get()
            ])->setPaper($this->setting_service->getSetting()->paper_size, 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);
            
            return $pdf->stream();
        }   
    }


    public function destroy(Request $request)
    {
        DB::beginTransaction();

        $main_transaksi = TransaksiOffline::findOrFail($request->get('id'));
        $backup_transaksi = $main_transaksi;

        if($main_transaksi->delete())
        {
            $details = TransaksiOfflineDetail::where('id_transaksi', $backup_transaksi->id)->get();

            if($details != null)
            {
                foreach ($details as $detail) {
                    $detail->delete();
                }
            }

            DB::commit();
            return redirect('pemasukan/transaksi-offline-list')->with('alert_success', 'Berhasil Dihapus'); 
        }

        DB::rollBack();
        return redirect('pemasukan/transaksi-offline-list')->with('alert_error', 'Gagal Hapus');
    }

    public function search()
    {
        return view('pemasukan::transaksi.search',['active'=>'transaksi-offline-search', 'title'=> 'Pencarian Transaksi']);
    }

    public function preview(Request $request)
    {
        if($request->ajax())
        {
            $date_range   = explode(" - ",$request->dates);

            $date_start   = date('Y-m-d',strtotime($date_range[0]));
            $date_end     = date('Y-m-d',strtotime($date_range[1]));

            $invoice_code = $request->invoice_code != null ? $this->transaksi_service->findById($request->invoice_code)->invoice_code : null;

            $data = $this->transaksi_service->getAll($date_start, $date_end, $invoice_code, $request->get('nama_customer'), $request->get('status_transaksi'));
            
            return View::make('pemasukan::transaksi.render-search', [
                'transaksi'=> $data->get(),
                'status_belum_lunas' => TransaksiOffline::STATUS_BELUM_LUNAS
            ]);       
        }
    }

    public function changeStatus(Request $request)
    {
        if($request->ajax())
        {   
            DB::beginTransaction();

            $main_transaksi = $this->transaksi_service->findById($request->param);
            $main_transaksi->status_transaksi = TransaksiOffline::STATUS_LUNAS;

            if($main_transaksi->save())
            {
                DB::commit();
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl    = route('transaksi-offline-detail', $data->id);
        $deleteUrl  = route('transaksi-offline-delete', $data->id);
        $print_resi = route('transaksi-offline-print', $data->id);

        if($data->status_transaksi == TransaksiOffline::STATUS_BELUM_LUNAS)
        {
            $button_change = "<button class='btn btn-info' data-value='$data->id' onclick=changeStatus('$data->id')><i class='fas fa-money-check-alt'></i></button>";
        }
        else
        {
            $button_change = null;
        }

        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$print_resi'><i class='fas fa-print'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a> &nbsp".$button_change;
    }

}
