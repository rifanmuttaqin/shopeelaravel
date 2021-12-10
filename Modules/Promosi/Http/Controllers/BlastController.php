<?php

namespace Modules\Promosi\Http\Controllers;

use App\Jobs\BlastWa;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\NotifyUserOfCompletedImport;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Collection;
use Modules\Promosi\Imports\Blast\BlastImport;

class BlastController extends Controller
{
    private $setting_service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingService $setting_service)
    {
        $this->middleware('auth');
        $this->setting_service = $setting_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('promosi::blast.index',['title'=> 'Blast Whatshapp','active'=>'blast']);
    }

    public function preview(Request $request)
    {
        if($request->hasFile('file'))
        {
            $data = $this->readExcel($request);
            return view('promosi::blast.partial_preview',['data'=>$data])->render();
        }
    }

    public function doblast(Request $request)
    {        
        if($request->hasFile('file'))
        {
            $data = $this->readExcel($request);
            
            dispatch(new BlastWa($data,$this->setting_service));

            return redirect('promosi/blast')->with('alert_success', 'Berhasil dijadwalkan kirim mohon ditunggu'); 
        }
    }


    // ----------- HELPER READ EXCEL -------------

    private function readExcel($request)
    {
        $data_excel = Excel::toArray(new BlastImport, $request->file);
        return $data_excel[0];
    }

}
