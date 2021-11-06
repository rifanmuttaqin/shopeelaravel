<?php

namespace Modules\Pengeluaran\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pengeluaran\Entities\Produkpo\Produkpo;
use Modules\Pengeluaran\Http\Requests\Produkpo\StoreProdukpoRequest;
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
                        $btn = '<button onclick="btnUbah('.$row->id.')" name="btnUbah" type="button" class="btn btn-info"><i class="far fa-edit"></i></button>';
                        $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                        return $btn .'&nbsp'. $delete; 
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
            return view('pengeluaran::show');
      }

      /**
       * Show the form for editing the specified resource.
       * @param int $id
       * @return Renderable
       */
      public function edit($id)
      {
            return view('pengeluaran::edit');
      }

      /**
       * Update the specified resource in storage.
       * @param Request $request
       * @param int $id
       * @return Renderable
       */
      public function update(Request $request, $id)
      {
            //
      }

      /**
       * Remove the specified resource from storage.
       * @param int $id
       * @return Renderable
       */
      public function destroy($id)
      {
            //
      }
}
