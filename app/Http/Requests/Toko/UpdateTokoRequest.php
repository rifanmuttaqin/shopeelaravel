<?php

namespace App\Http\Requests\Toko;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class UpdateTokoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'nama_toko'            => 'required|string|min:2|unique:tbl_user_toko,nama_toko,'. $request->get('id'),
            'alamat_toko'          => 'required|string|min:2',
            'link_shopee'          => 'required|string|unique:tbl_user_toko,link_shopee,'. $request->get('id')
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return 
        [
            'nama_toko.required'    => 'Nama Toko tidak boleh Kosong',
            'alamat_toko.required'  => 'Alamat Toko tidak boleh Kosong',
            'link_shopee.required'  => 'Link Shopee Toko tidak boleh Kosong',
            'link_shopee.unique'    => 'Link Shopee Toko telah ada sebelumnya',
            'nama_toko.unique'      => 'Nama Toko sudah ada sebelumnya',
        ];
    }
}
