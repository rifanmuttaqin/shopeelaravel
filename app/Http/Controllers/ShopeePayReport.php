<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\Shopeepay\ShopeepayImport;

class ShopeePayReport extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application transaksi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('shopeepay.index', ['active'=>'shopeepay', 'title'=>'ShopeePayReport']);   
    }

    /**
     */
    public function doImport(Request $request)
    {
        if($request->hasFile('file'))
        {
            $file       = $request->file('file');

            $fileName   = time() . '.' . $file->getClientOriginalExtension();
            $path       = $file->getRealPath();
            $name       = $file->getClientOriginalName();
            $name       = explode(".",$name);
            $name       = $name[0];
                
            $run_import = Excel::import($import = new ShopeepayImport($name), $file);

            if($import->result)
            {
                return redirect('transaksi')->with('alert_success', 'Berhasil Diimport | Silahkan lanjut ke pencetakkan');
            }
            else
            {
                return redirect('transaksi')->with('alert_error', 'TERDAPAT KESALAHAN PADA FORMAT DATA');
            }
        }
        else
        {
            return redirect('transaksi')->with('alert_error', 'FILE KOSONG | Masukkan File Sesuai dengan FORMAT');
        }
    }

}
