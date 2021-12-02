<?php

namespace Modules\Pengeluaran\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pengeluaran\Entities\Produkpo\Produkpo;
use Modules\Pengeluaran\Http\Requests\Produkpo\StoreProdukpoRequest;
use Modules\Pengeluaran\Http\Requests\Produkpo\UpdateProdukpoRequest;
use Modules\Pengeluaran\Services\ProdukpoService;
use Yajra\Datatables\Datatables;

class ProdukpoController extends Controller
{
      private $produk_po_service;

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct(ProdukpoService $produk_po_service)
      {
            $this->middleware('auth');
            $this->produk_po_service = $produk_po_service;
      }

      /**
       * Display a listing of the resource.
       * @return Renderable
       */
      public function index(Request $request)
      {
            if ($request->ajax()) 
            {
                  $data = $this->produk_po_service->getAll();

                  return Datatables::of($data)
                  ->addColumn('action', function($row){  
                        return $this->getActionColumn($row);
                  })->make(true);
            }

            return view('pengeluaran::produk_po.index',['active'=>'produk_po', 'title'=> 'Produk Bahan Baku']);
      }

      /**
       * Show the form for creating a new resource.
       * @return Renderable
       */
      public function create()
      {
            return view('pengeluaran::produk_po.create',['active'=>'produk_po', 'title'=> 'Tambah Data Produk']);
      }

      /**
       * Store a newly created resource in storage.
       * @param Request $request
       * @return Renderable
       */
      public function store(StoreProdukpoRequest $request)
      {
            DB::beginTransaction();   

            $model          = new Produkpo($request->all());
            $model->user_created = $this->getUserLogin()->id;

            if(!$model->save())
            {
                  DB::rollBack();
                  return redirect('pengeluaran/produk')->with('alert_error', 'Gagal Disimpan');
            }

            DB::commit();
            return redirect('pengeluaran/produk')->with('alert_success', 'Berhasil Disimpan'); 
      }

      /**
       * Show the specified resource.
       * @param int $id
       * @return Renderable
       */
      public function show($id)
      {
            if($id != null)
            {
                  $data_produk = $this->produk_po_service->findById($id);
                  return view('pengeluaran::produk_po.show',['active'=>'produk_po', 'title'=> 'Detail Produk Bahan Baku '.$data_produk->nama_produk,'data_produk'=>$data_produk]);
            }     
      }

      public function delete($id)
      {
            if($id != null)
            {
                  $data_produk = $this->produk_po_service->findById($id);
                  return view('pengeluaran::produk_po.delete',['active'=>'produk_po', 'title'=> 'Hapus Produk Bahan Baku '.$data_produk->nama_produk,'data_produk'=>$data_produk]);
            }     
      }

      /**
       * Show the form for editing the specified resource.
       * @param int $id
       * @return Renderable
       */
      public function edit($id)
      {
            if($id != null)
            {
                  $data_produk = $this->produk_po_service->findById($id);
                  return view('pengeluaran::produk_po.edit',['active'=>'produk_po', 'title'=> 'Update Produk Bahan Baku '.$data_produk->nama_produk,'data_produk'=>$data_produk]);
            }
      }

      /**
       * Update the specified resource in storage.
       * @param Request $request
       * @param int $id
       * @return Renderable
       */
      public function update(UpdateProdukpoRequest $request)
      {
            DB::beginTransaction();

            $model = Produkpo::findOrFail($request->id)->update($request->all());
    
            if($model)
            {
                DB::commit();
                return redirect('pengeluaran/produk')->with('alert_success', 'Berhasil Disimpan'); 
            }
    
            DB::rollBack();
            return redirect('pengeluaran/produk')->with('alert_error', 'Gagal Simpan');
      }

      /**
       * Remove the specified resource from storage.
       * @param int $id
       * @return Renderable
       */
      public function destroy(Request $request)
      {
            DB::beginTransaction();
    
            if(Produkpo::findOrFail($request->get('id'))->delete())
            {
                DB::commit();
                return redirect('pengeluaran/produk')->with('alert_success', 'Berhasil Dihapus'); 
            }
    
            DB::rollBack();
            return redirect('pengeluaran/produk')->with('alert_error', 'Gagal Hapus');
      }

      /**
       * List 
       *
       * @return \Illuminate\Http\Response
       */
      public function list(Request $request)
      {
            if($request->ajax())
            {
                  $produks    = $this->produk_po_service->getAll($request->get('search'));
                  $arr_data   = array();
                  $key = 0;             

                  if($produks != null)
                  {
                        foreach ($produks->get() as $produk) 
                        {
                              $arr_data[$key]['id']   = $produk->id;
                              $arr_data[$key]['text'] = $produk->nama_produk;
                              $arr_data[$key]['price'] = $produk->harga;
                              $key++;
                        }
                  }

                  return json_encode($arr_data);
            }
      }

      // --------------- HELPER FUNCTION --------------
      
      /**
       * @param $data
       * @return string
       */
      protected function getActionColumn($data): string
      {
            $showUrl    = route('produkpo-show', $data->id);
            $editUrl    = route('produkpo-edit', $data->id);
            $deleteUrl  = route('produkpo-delete', $data->id);
            
            return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
            <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
            <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
      }
}
