<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\HistoryCetakService;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class HistoryCetakLabelController extends Controller
{
    private $history;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HistoryCetakService $history)
    {
        $this->middleware('auth');

        $this->history = $history;
    }

    /**
     * 
     * Display a listing of the resource.
     * @return void
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->history->getAll();

            return Datatables::of($data)
            ->addColumn('user_toko_id', function($row){
                return isset($row->toko) ? $row->toko->nama_toko : 'Keseluruhan';
            })
            ->addColumn('created_at', function($row){
                return Carbon::parse($row->created_at)
                ->format('d F Y H:i');
            })
            ->addColumn('action', function($row){  
                $btn = '<button onclick="btnPrint('.$row->id.')" name="btnPrint" type="button" class="btn btn-info"><i class="far fa-file-pdf"></i></button>';
                return $btn; 
            })
            ->make(true);
        }

        return view('history-cetak.index', ['active'=>'history-cetak', 'title'=> 'Riwayat Pencetakan']);
    }

}
