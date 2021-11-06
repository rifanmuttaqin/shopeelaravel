<?php

namespace Modules\Pengeluaran\Http\Requests\Produkpo;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukpoRequest extends FormRequest
{
      /**
       * Get the validation rules that apply to the request.
       *
       * @return array
       */
      public function rules()
      {
            return [
                  'nama_produk'           => 'required|string|min:2',
                  'harga'                 => 'required|numeric',
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
