<?php

namespace Modules\Pemasukan\Http\Requests\CustomerOffline;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerOfflineRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama'                   => 'required|string|min:2',
            'alamat'                 => 'nullable|string',
            'no_hp'                  => 'nullable|string',
            'akun_shopee'            => 'nullable|string',
            'status_aktif'           => 'required|integer'       
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
