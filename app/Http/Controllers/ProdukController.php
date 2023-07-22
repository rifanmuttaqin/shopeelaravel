<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\ProdukRequest;
use App\Interfaces\ProductInterface;
use App\Model\Produk\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\SelectResponseTrait;


class ProdukController extends Controller
{
    use SelectResponseTrait;
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
            Produk::create(array_merge(['is_grosir'=> $request->is_grosir === 'on' ? true : false],$request->except('is_grosir')));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect('produk')->with('alert_success', 'Berhasil Disimpan');

    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', [
            'produk'        => $produk,
            'active'        => 'produk',
            'title'         => 'Edit Produk '.$produk->nama_produk,
        ]);
    }


    public function update(ProdukRequest $request, Produk $produk)
    {
        DB::beginTransaction();

        try {
            $produk->update(array_merge(['is_grosir'=> $request->is_grosir === 'on' ? true : false],$request->except('is_grosir')));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect('produk')->with('alert_success', 'Berhasil Diupdate');
    }


    public function show(Produk $produk)
    {
        return view('produk.show', [
            'produk'        => $produk,
            'active'        => 'produk',
            'title'         => 'Detail Produk '.$produk->nama_produk,
        ]);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        DB::beginTransaction();

        try {
            $produk->deactive();
        } catch (QueryException $err) {

            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage());
        } finally {
            DB::commit();
        }

        return redirect()->route('produk')->with('success', __('Berhasil dihapus'));
    }


    public function list(Request $request)
    {
        $produks    = $this->product->getAll($request->get('search'));
        return $this->generateSelectResponse($produks,'nama_produk',$request->get('type_product'));
    }
    
}
