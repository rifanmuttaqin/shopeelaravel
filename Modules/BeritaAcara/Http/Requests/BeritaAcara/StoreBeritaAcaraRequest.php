<?php

namespace Modules\BeritaAcara\Http\Requests\BeritaAcara;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaAcaraRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tanggal'                  => 'required|date',
            'detail_kejadian'          => 'required|string',
            'transaksi_id'             => 'nullable|integer',
            'nominal_kerugian'         => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'image_pendukung'          => 'nullable|string',
            'status_masalah'           => 'required|integer',                     
            'status_aktif'             => 'required|integer'       
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
