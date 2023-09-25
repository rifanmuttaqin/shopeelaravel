<?php

namespace App\Http\Requests\CashFlow;

use Illuminate\Foundation\Http\FormRequest;

class CashFlowComponentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
               return $this->store();
            case 'PUT':
                return $this->update();
            default:
                null;
            break;
        }
    }

/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function store() 
    {
        return [
            'category_name'             => 'required|string|min:2',
            'type'                      => 'required|numeric',
            'note'                      => 'required|string', 
        ];
    }

    public function update()
    {
        return [
            'category_name'             => 'required|string|min:2',
            'type'                      => 'required|numeric',
            'note'                      => 'required|string', 
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