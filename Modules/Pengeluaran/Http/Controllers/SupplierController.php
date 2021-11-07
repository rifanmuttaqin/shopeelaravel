<?php

namespace Modules\Pengeluaran\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pengeluaran\Entities\Supplier\Supplier;
use Modules\Pengeluaran\Http\Requests\Supplier\StoreSupplierRequest;
use Modules\Pengeluaran\Http\Requests\Supplier\UpdateSupplierRequest;
use Modules\Pengeluaran\Services\SupplierService;
use Yajra\Datatables\Datatables;

class SupplierController extends Controller
{
      private $supplier_service;

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct(SupplierService $supplier_service)
      {
            $this->middleware('auth');
            $this->supplier_service = $supplier_service;
      }

      /**
       * Display a listing of the resource.
       * @return Renderable
       */
      public function index(Request $request)
      {
            if ($request->ajax()) 
            {
                  $data = $this->supplier_service->getAll();

                  return Datatables::of($data)
                  ->addColumn('action', function($row){  
                        return $this->getActionColumn($row);
                  })->make(true);
            }

            return view('pengeluaran::supplier.index',['active'=>'supplier', 'title'=> 'Pengelolaan Supplier']);
      }

      /**
       * Show the form for creating a new resource.
       * @return Renderable
       */
      public function create()
      {
            return view('pengeluaran::supplier.create',['active'=>'supplier', 'title'=> 'Tambah Data Supplier']);
      }

      /**
       * Store a newly created resource in storage.
       * @param Request $request
       * @return Renderable
       */
      public function store(StoreSupplierRequest $request)
      {
            DB::beginTransaction();   

            $model          = new Supplier($request->all());
            $model->user_created = $this->getUserLogin()->id;

            if(!$model->save())
            {
                  DB::rollBack();
                  return redirect('pengeluaran/supplier')->with('alert_error', 'Gagal Disimpan');
            }

            DB::commit();
            return redirect('pengeluaran/supplier')->with('alert_success', 'Berhasil Disimpan'); 
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
                  $data_supplier = $this->supplier_service->findById($id);
            
                  return view('pengeluaran::supplier.show',['active'=>'supplier', 'title'=> 'Detail Supplier '.$data_supplier->nama,'data_supplier'=>$data_supplier]);
            }     
      }

      public function delete($id)
      {
            if($id != null)
            {
                  $data_supplier = $this->supplier_service->findById($id);
            
                  return view('pengeluaran::supplier.delete',['active'=>'supplier', 'title'=> 'Hapus Supplier '.$data_supplier->nama,'data_supplier'=>$data_supplier]);
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
                  $data_supplier = $this->supplier_service->findById($id);

                  return view('pengeluaran::supplier.edit',['active'=>'supplier', 'title'=> 'Update Supplier '.$data_supplier->nama,'data_supplier'=>$data_supplier]);
            }
      }

      /**
       * Update the specified resource in storage.
       * @param Request $request
       * @param int $id
       * @return Renderable
       */
      public function update(UpdateSupplierRequest $request)
      {
            DB::beginTransaction();

            $model = Supplier::findOrFail($request->id)->update($request->all());
    
            if($model)
            {
                DB::commit();
                return redirect('pengeluaran/supplier')->with('alert_success', 'Berhasil Disimpan'); 
            }
    
            DB::rollBack();
            return redirect('pengeluaran/supplier')->with('alert_error', 'Gagal Simpan');
      }

      /**
       * Remove the specified resource from storage.
       * @param int $id
       * @return Renderable
       */
      public function destroy(Request $request)
      {
            DB::beginTransaction();
    
            if(Supplier::findOrFail($request->get('id'))->delete())
            {
                DB::commit();
                return redirect('pengeluaran/supplier')->with('alert_success', 'Berhasil Dihapus'); 
            }
    
            DB::rollBack();
            return redirect('pengeluaran/supplier')->with('alert_error', 'Gagal Hapus');
      }

      // --------------- HELPER FUNCTION --------------
      
      /**
       * @param $data
       * @return string
       */
      protected function getActionColumn($data): string
      {
            $showUrl    = route('supplier-show', $data->id);
            $editUrl    = route('supplier-edit', $data->id);
            $deleteUrl  = route('supplier-delete', $data->id);
            
            return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
            <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
            <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
      }
}
