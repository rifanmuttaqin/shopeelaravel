<?php

namespace App\Http\Controllers;

use App\Model\Toko\Toko;

use App\Services\TokoService;

use App\Http\Requests\Toko\StoreTokoRequest;
use App\Http\Requests\Toko\UpdateTokoRequest;


use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

use DB;

class TokoController extends Controller
{

    public $toko_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TokoService $toko_service)
    {
        $this->middleware('auth');
        $this->toko_service = $toko_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
           	$data = $this->toko_service->getAll();

            return Datatables::of($data)->addColumn('action', function($row){  
                $btn = '<button onclick="btnUbah('.$row->id.')" name="btnUbah" type="button" class="btn btn-info"><i class="far fa-edit"></i></button>';
                $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                return $btn .'&nbsp'. $delete; 
            })->make(true);
        }

        return view('toko.index', ['active'=>'toko', 'title'=> 'Daftar Toko Pengguna']);
    }

    /**
     * 
     * @return
     */
    public function create(Request $request)
    {
        return view('toko.store', ['active'=>'toko', 'title'=> 'Halaman Input Toko']);
    }

    /**
     * 
     * @return
     */
    public function edit($id=null)
    {
        $data_toko = Toko::findOrFail($id);

        return view('toko.update', ['active'=>'toko', 'title'=> 'Halaman Update Toko', 'data_toko' => $data_toko]);
    }

    /**
     * 
     * @return
     */
    public function update(UpdateTokoRequest $request)
    {
        DB::beginTransaction();

        $toko_model = Toko::findOrFail($request->id)->update($request->all()); // Menggunakan mass Assignment

        if($toko_model)
        {
            DB::commit();
            return redirect('toko')->with('alert_success', 'Berhasil Diupdate'); 
        }

        DB::rollBack();
        return redirect('toko')->with('alert_error', 'Gagal Diupdate');
    }

    /**
     * 
     * @return
     */
    public function store(StoreTokoRequest $request)
    {
        DB::beginTransaction();   
     
        $toko_model          = new Toko($request->all()); // Menggunakan mass Assignment
        $toko_model->user_id = $this->getUserLogin()->id;

        if(!$toko_model->save())
        {
            DB::rollBack();
            return redirect('toko')->with('alert_error', 'Gagal Disimpan');
        }

        DB::commit();
        return redirect('toko')->with('alert_success', 'Berhasil Disimpan'); 
    }

    /**
     * List Toko
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->ajax())
        {
            $data_toko = null;
            $data_toko = $this->toko_service->getAll($request->get('search'));
          
            $arr_data      = array();

            if($data_toko != null)
            {
                $key = 0;

                foreach ($data_toko as $data) 
                {
                    $arr_data[$key]['id']   = $data->id;
                    $arr_data[$key]['text'] = $data->nama_toko;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }


    /**
     * Menghapus Toko
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
            if($request->ajax())
            {
                  DB::beginTransaction(); 
                  
                  $toko = $this->toko_service->findById($request->param);

                  if($toko->delete())
                  {
                        DB::commit();
                        return $this->getResponse(true,200,null,'Berhasil dihapus');
                  }

                  DB::rollBack();
                  return $this->getResponse(false,400,null,'Gagal delete | Terjadi kesalahan / Data sedang digunakan');
            }
    }

}
