<?php

namespace Modules\Pemasukan\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_produk'                   => 'required|string|min:2',
            'harga'                         => 'required|numeric',
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
