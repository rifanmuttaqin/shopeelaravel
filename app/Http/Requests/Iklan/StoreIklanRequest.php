<?php

namespace App\Http\Requests\Iklan;

use Illuminate\Foundation\Http\FormRequest;

class StoreIklanRequest extends FormRequest
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
            'param.user_toko_id'         => 'integer|required',          
            'param.total_iklan'          => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'param.date'                 => 'date|required'
        ];
    }
}
