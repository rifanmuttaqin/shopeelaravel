<?php

namespace Modules\BeritaAcara\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\BeritaAcara\Services\BeritaAcaraService;
use Yajra\Datatables\Datatables;

class BeritaAcaraController extends Controller
{

    private $berita_acara_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BeritaAcaraService $berita_acara_service)
    {
        $this->middleware('auth');
        $this->berita_acara_service = $berita_acara_service;
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
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })->make(true);
        }

        return view('beritaacara::beritaacara.index', ['active'=>'beritaacara', 'title'=> 'Berita Acara Kerusakan / Kehilangan / Kerugian']);
    }

    public function create(Request $request)
    {
        return view('beritaacara::beritaacara.create',['active'=>'beritaacara', 'title'=> 'Berita Acara Baru']);
    }


}
