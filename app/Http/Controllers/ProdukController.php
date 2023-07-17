<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\ProdukRequest;
use App\Interfaces\ProductInterface;
use App\Model\Produk\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if($request->ajax())
        {
            $product = $this->product->getAll();

            return datatables()->of($product)->addColumn('action', function ($product) {
                return view('produk.action', [
                    'product' => $product
                ]);
            })->make(true);
        }

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

    public function store(ProdukRequest $request)
    {
        DB::beginTransaction();

        try {
            Produk::create(array_merge(['is_grosir'=> request()->is_grosir === 'on' ? true : false],$request->all()));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect('produk')->with('alert_success', 'Berhasil Disimpan');

    }

}
