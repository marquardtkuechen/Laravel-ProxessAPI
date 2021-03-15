<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveFileRequest extends FormRequest
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
            'DatabaseName' => 'required',
            'CommissionNr' => 'required|numeric|min:0',
            'ReceiptType' => 'required|numeric|min:0',
            'PosNr'=> 'nullable|numeric|min:0',
            'Description'=> 'nullable',
            'Document'=> 'required'
        ];
    }
}
