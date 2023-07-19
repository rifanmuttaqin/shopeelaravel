<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
               return $this->store();
            case 'PUT':
                return $this->update();
            default:
                null;
            break;
        }
    }


/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function store() 
    {
        return [
            'nama_produk'                   => 'required|string|min:2',
            'harga'                         => 'required|numeric',
            'harga_po'                      => 'required|numeric',
            'harga_grosir_satu'             => 'nullable|numeric',
            'harga_grosir_dua'              => 'nullable|numeric',
            'minimal_pengambilan_satu'      => 'nullable|integer',
            'minimal_pengambilan_dua'       => 'nullable|integer',           
            'status_aktif'                  => 'required|integer'       
        ];
    }

    public function update()
    {
        return [
            'nama_produk'                   => ['required', 'string', 'unique:tbl_produk,nama_produk,' .$this->produk->id],
            'harga'                         => 'required|numeric',
            'harga_po'                      => 'required|numeric',
            'harga_grosir_satu'             => 'nullable|numeric',
            'harga_grosir_dua'              => 'nullable|numeric',
            'minimal_pengambilan_satu'      => 'nullable|integer',
            'minimal_pengambilan_dua'       => 'nullable|integer',           
            'status_aktif'                  => 'required|integer'       
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


}