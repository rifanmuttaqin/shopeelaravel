<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'nama'                  => 'string|min:2',
            'email'                 => 'required|email|unique:tbl_user',
            'nomor_hp'              => 'string|min:2|nullable',
            'profile_picture'       => 'string|nullable',
            'account_type'          => 'integer|required',            
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
            'nik.required'               => 'NIK Tidak Boleh Kosong',
            'email.required'             => 'Email Tidak Boleh Kosong',
            'provinsi_id.required'       => 'Provinsi Tidak Boleh Kosong',
            'account_type.required'      => 'Akun Tipe Tidak Boleh Kosong',        
        ];
    }
}
