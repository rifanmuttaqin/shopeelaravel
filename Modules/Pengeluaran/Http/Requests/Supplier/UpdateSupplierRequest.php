<?php

namespace Modules\Pengeluaran\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
      /**
       * Get the validation rules that apply to the request.
       *
       * @return array
       */
      public function rules()
      {
            return [
                  'nama'                  => 'required|string|min:2',
                  'kontak'                => 'nullable|string',
                  'alamat'                => 'nullable|string',
                  'keterangan'            => 'nullable|string',
                  'status_aktif'          => 'required|integer'        
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
