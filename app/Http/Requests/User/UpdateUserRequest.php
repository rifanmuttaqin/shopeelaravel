<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
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
            'email'           => 'required|email|unique:tbl_user,email,'. $request->get('iduser'),
            'profile_picture' => 'string|nullable',
            'nama'            => 'string|nullable',
            'nomor_hp'        => 'string|nullable',
            'account_type'    => 'integer|required'
        ];
        
    }
}
