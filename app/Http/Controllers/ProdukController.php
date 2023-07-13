<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('produk.index', ['active'=>'produk', 'title'=>'Produk']);   
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('produk.create',['active'=>'produk', 'title'=> 'Tambah Produk Baru']);
    }

}
