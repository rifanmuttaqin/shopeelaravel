<?php

namespace Modules\Pemasukan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\Produk\Produk;
use Modules\Pemasukan\Http\Requests\Produk\StoreProdukRequest;
use Modules\Pemasukan\Http\Requests\Produk\UpdateProdukRequest;
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
        
        $validate = $this->manualValidate($request);
        
        if ($validate != null)
        {
            return redirect('pemasukan/produk')->with('alert_error', $validate);
        }

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

    private function manualValidate($request)
    {
        $status     = true;
        $message    = null;

        if($request->get('is_grosir'))
        {
            if($request->get('harga') <= $request->get('harga_grosir_satu'))
            {
                $status = false;
                $message = 'Harga Grosir harusnya lebih murah dong ya, silahkan cek kembali, dan ulangi input anda';
            }
            else if($request->get('harga') <= $request->get('harga_grosir_dua'))
            {
                $status = false;
                $message = 'Harga Grosir harusnya lebih murah dong ya, silahkan cek kembali, dan ulangi input anda';
            }

            if($$request->get('harga_grosir_dua') != null || $request->get('minimal_pengambilan_dua') != null)
            {
                if($request->get('harga_grosir_satu') <= $request->get('harga_grosir_dua'))
                {
                    $status = false;
                    $message = 'Harga Grosir tingkat satu harusnya lebih murah dong ya daripada tingkat duanya, silahkan cek kembali, dan ulangi input anda';
                }

                if($request->get('minimal_pengambilan_satu') >= $request->get('minimal_pengambilan_dua'))
                {
                    $status = false;
                    $message = 'Seharusnya minimal pengambilan pada grosir tingkat 2 lebih tinggi daripada tingkat satu';
                }
            }

            

            if(!$status)
            {
                return $message;
            }

            return;
        }
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if($id != null)
        {
            $data_produk = $this->produk_service->findById($id);
            return view('pemasukan::produk.edit',['active'=>'produk', 'title'=> 'Update Produk Jual '.$data_produk->nama_produk,'data_produk'=>$data_produk]);
        }
    }
    

    public function delete($id)
    {
        if($id != null)
        {
            $data_produk = $this->produk_service->findById($id);
            return view('pemasukan::produk.delete',['active'=>'produk', 'title'=> 'Hapus Produk Jual '.$data_produk->nama_produk,'data_produk'=>$data_produk]);
        }     
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        if(Produk::findOrFail($request->get('id'))->delete())
        {
            DB::commit();
            return redirect('pemasukan/produk')->with('alert_success', 'Berhasil Dihapus'); 
        }

        DB::rollBack();
        return redirect('pemasukan/produk')->with('alert_error', 'Gagal Hapus');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateProdukRequest $request)
    {
        DB::beginTransaction();

        $data_before_save = $request->all();

        if($request->is_grosir == null)
        {
            $data_before_save['is_grosir'] = false;
            $data_before_save['harga_grosir_satu'] = null;
            $data_before_save['minimal_pengambilan_satu'] = null;
            $data_before_save['harga_grosir_dua'] = null;
            $data_before_save['minimal_pengambilan_dua'] = null;
        }
        else
        {
            $data_before_save['is_grosir'] = true;
        }

        $model = Produk::findOrFail($request->id)->update($data_before_save);

        if($model)
        {
            DB::commit();
            return redirect('pemasukan/produk')->with('alert_success', 'Berhasil Disimpan'); 
        }

        DB::rollBack();
        return redirect('pemasukan/produk')->with('alert_error', 'Gagal Simpan');
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pemasukan::produk.create',['active'=>'produk', 'title'=> 'Tambah Produk Baru']);
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
                $produks    = $this->produk_service->getAll($request->get('search'));
                $arr_data   = array();
                $key = 0;             

                if($produks != null)
                {
                    foreach ($produks->get() as $produk) 
                    {
                        $arr_data[$key]['id']   = $produk->id;
                        $arr_data[$key]['text'] = $produk->nama_produk;

                        if($produk->is_grosir)
                        {
                            $arr_data[$key]['text'] = $produk->nama_produk.' (Grosir)';
                        }
                        
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
        $showUrl    = route('produk-show', $data->id);
        $editUrl    = route('produk-edit', $data->id);
        $deleteUrl  = route('produk-delete', $data->id);
        
        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
        <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
    }

}
