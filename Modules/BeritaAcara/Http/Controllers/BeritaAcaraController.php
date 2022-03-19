<?php

namespace Modules\BeritaAcara\Http\Controllers;

use App\Services\TransaksiService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\BeritaAcara\Entities\BeritaAcara\BeritaAcara;
use Modules\BeritaAcara\Services\BeritaAcaraService;
use Modules\BeritaAcara\Http\Requests\BeritaAcara\StoreBeritaAcaraRequest;
use Modules\BeritaAcara\Http\Requests\BeritaAcara\UpdateBeritaAcaraRequest;
use Yajra\Datatables\Datatables;

class BeritaAcaraController extends Controller
{
    private $berita_acara_service;
    private $transaksi_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BeritaAcaraService $berita_acara_service, TransaksiService $transaksi_service)
    {
        $this->middleware('auth');
        $this->berita_acara_service = $berita_acara_service;
        $this->transaksi_service = $transaksi_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->berita_acara_service->getAll();

            return Datatables::of($data)
            ->addColumn('detail_kejadian', function($row){  
                return $this->berita_acara_service->getReadmore($row);
            })
            ->addColumn('status_masalah', function($row){  
                return $this->berita_acara_service->statusMasalahMeaning($row->status_masalah);
            })
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })->make(true);
        }

        return view('beritaacara::beritaacara.index', ['active'=>'beritaacara', 'title'=> 'Berita Acara Kerusakan / Kehilangan / Kerugian']);
    }

    public function search(){
        return view('beritaacara::beritaacara.search',['active'=>'beritaacara', 'title'=> 'Pencarian Lanjutan Berita Acara']);
    }

    public function create(Request $request)
    {
        return view('beritaacara::beritaacara.create',['active'=>'beritaacara', 'title'=> 'Berita Acara Baru']);
    }

    public function show($id=null)
    {
        if($id != null)
        {
            $berita_acara_service = $this->berita_acara_service;
            return view('beritaacara::beritaacara.show',[
                'active'=>'beritaacara', 
                'title'=> 'Detail Berita Acara',
                'data'=>$berita_acara_service->findById($id),
                'berita_acara_service'=>$berita_acara_service,
                'transaksi_service'=>$this->transaksi_service
            ]);
        }
    }
    
    public function delete($id=null)
    {
        if($id != null)
        {
            $berita_acara_service = $this->berita_acara_service;
            return view('beritaacara::beritaacara.delete',[
                'active'=>'beritaacara', 
                'title'=> 'Hapus Berita Acara',
                'data'=>$berita_acara_service->findById($id), 
                'berita_acara_service'=>$berita_acara_service,
                'transaksi_service'=>$this->transaksi_service
            ]);
        }
    }

    
    public function store(StoreBeritaAcaraRequest $request)
    {
        try {
            DB::beginTransaction();   
            $berita_acara_model = new BeritaAcara($request->all());
            $berita_acara_model->save();
            
            DB::commit();
            return redirect('beritaacara')->with('alert_success', 'Berhasil Disimpan');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('beritaacara')->with('alert_error', 'Gagal Disimpan');
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
            $data = $this->berita_acara_service->findById($id);
            return view('beritaacara::beritaacara.edit',[
                'active'=>'beritaacara', 
                'title'=> 'Perubahan Berita Acara',
                'data'=>$data,
                'transaksi_service'=>$this->transaksi_service
            ]);
        }
    }


    /**
       * Update the specified resource in storage.
       * @param Request $request
       * @param int $id
       * @return Renderable
    */
    public function update(UpdateBeritaAcaraRequest $request)
    {
    try {
        DB::beginTransaction();
        $model = BeritaAcara::findOrFail($request->id)->update($request->all());

        DB::commit();
        return redirect('beritaacara')->with('alert_success', 'Berhasil Disimpan');

    } catch (\Throwable $th) {
        DB::rollBack();
        return redirect('beritaacara')->with('alert_error', 'Gagal Simpan');
    }
    }
    
    public function destroy(Request $request){

        try {
            DB::beginTransaction();
            BeritaAcara::findOrFail($request->get('id'))->delete();

            DB::commit();
            return redirect('beritaacara')->with('alert_success', 'Berhasil Dihapus'); 
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('beritaacara')->with('alert_error', 'Gagal Hapus');
        }
    }

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl    = route('beritaacara-show', $data->id);
        $editUrl    = route('beritaacara-edit', $data->id);
        $deleteUrl  = route('beritaacara-delete', $data->id);
        
        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
        <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
    }

}
