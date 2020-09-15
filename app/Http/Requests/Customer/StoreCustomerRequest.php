<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
    public function rules()
    {
        return [ 
            'username_pembeli'         => 'string|required',          
            'nama_pembeli'             => 'string|required',
            'telfon_pembeli'           => 'string|required',
            'alamat_pembeli'           => 'string|required',
            'kota_pembeli'             => 'string|required',
            'provinsi_pembeli'         => 'string|required',
            'kode_pos_pembeli'         => 'string|required'
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
            'username_pembeli.required'     => 'Username dari pesanan tidak diizinkan untuk kosong',   
            'nama_pembeli.required'         => 'Nama Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'telfon_pembeli.required'       => 'Telfon Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'alamat_pembeli.required'       => 'Alamat Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'kota_pembeli.required'         => 'Kota Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'provinsi_pembeli.required'     => 'Provinsi Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'kode_pos_pembeli.required'     => 'Kode Pos Pembeli dari pesanan tidak diizinkan untuk kosong'
        ];
    }
}
