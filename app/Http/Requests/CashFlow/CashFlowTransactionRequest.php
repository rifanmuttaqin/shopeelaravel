<?php

namespace App\Http\Requests\CashFlow;

use Illuminate\Foundation\Http\FormRequest;

class CashFlowTransactionRequest extends FormRequest
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
            'cash_flow_camponent_id'    => 'required',
            'date'                      => 'required|date',
            'amount'                    => 'required|numeric',
            'note'                      => 'required|string', 
        ];
    }

    public function update()
    {
        return [
            'cash_flow_camponent_id'    => 'required',
            'date'                      => 'required|date',
            'amount'                    => 'required|numeric',
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