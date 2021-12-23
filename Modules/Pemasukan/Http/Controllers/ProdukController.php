<?php

namespace Modules\Pemasukan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\Produk\Produk;
use Modules\Pemasukan\Http\Requests\Produk\StoreProdukRequest;
use Modules\Pemasukan\Services\ProdukService;
use Yajra\Datatables\Datatables;

class ProdukController extends Controller
{
    private $produk_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProdukService $produk_service)
    {
        $this->middleware('auth');
        $this->produk_service = $produk_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->produk_service->getAll();

            return Datatables::of($data)
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })->make(true);
        }

        return view('pemasukan::produk.index',['active'=>'produk', 'title'=> 'Daftar Produk Jual']);
    }

    public function store(StoreProdukRequest $request)
    {
        DB::beginTransaction();
        
        $model = new Produk($request->all());

        if($request->get('is_grosir'))
        {
            $model->is_grosir = true;
        }
        else
        {
            $model->is_grosir = false;
            $model->harga_grosir_satu = null;
            $model->harga_grosir_dua = null;
            $model->minimal_pengambilan_satu = null;
            $model->minimal_pengambilan_dua = null;
        }

        if(!$model->save())
        {
            DB::rollBack();
            return redirect('pemasukan/produk')->with('alert_error', 'Gagal Disimpan');
        }

        DB::commit();
        return redirect('pemasukan/produk')->with('alert_success', 'Berhasil Disimpan');

    }

    public function show($id=null)
    {
        if($id != null)
        {
            $data_produk = $this->produk_service->findById($id);
            return view('pemasukan::produk.show',['active'=>'produk', 'title'=> 'Detail Produk Jual '.$data_produk->nama_produk,'data_produk'=>$data_produk]);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pemasukan::produk.create',['active'=>'produk', 'title'=> 'Tambah Produk Baru']);
    }


    // --------------- HELPER FUNCTION --------------

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl    = route('produk-show', $data->id);
        $editUrl    = route('produk-edit', $data->id);
        $deleteUrl  = route('produk-delete', $data->id);
        
        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
        <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
    }

}
