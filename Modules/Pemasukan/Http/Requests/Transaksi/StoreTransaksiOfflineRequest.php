<?php

namespace Modules\Pemasukan\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiOfflineRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_customer'        => 'required|integer',
            'total_amount'         => 'required|numeric',
            'discount_amount'      => 'nullable|numeric',
            'produk_chart'         => 'required',
            'status_transaksi'     => 'required',
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
