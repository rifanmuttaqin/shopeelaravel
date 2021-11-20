<?php

namespace Modules\Pengeluaran\Http\Requests\TransaksiPo;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiPoRequest extends FormRequest
{
      /**
       * Get the validation rules that apply to the request.
       *
       * @return array
       */
      public function rules()
      {
            return [
                'supplier_name'        => 'required|string|min:2',
                'total_amount'         => 'required|numeric',
                'discount_amount'      => 'required|numeric',
                'keterangan'           => 'nullable|string|min:2',
                'nota'                 => 'required|string|min:2'
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
