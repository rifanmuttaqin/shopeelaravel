<?php

namespace App\Http\Controllers;

use App\Services\EkspedisiService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EkspedisiController extends Controller
{
    private $ekspedisi_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EkspedisiService $ekspedisi_service)
    {
        $this->middleware('auth');
        $this->ekspedisi_service = $ekspedisi_service;
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
                $data = $this->ekspedisi_service->getAll();

                return DataTables::of($data)->make(true);
            }

            return view('ekspedisi.index', ['active'=>'ekspedisi', 'title'=> 'Ekspedisi']);
      }


}
