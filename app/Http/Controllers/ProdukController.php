<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;

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

}
