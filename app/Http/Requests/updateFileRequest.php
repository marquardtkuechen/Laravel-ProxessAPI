<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateFileRequest extends FormRequest
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
            'DocumentID'   => 'required|numeric|min:0',
            'FileID'       => 'required|numeric|min:0',
            'CommissionNr' => 'required|numeric|min:0',
            'PosNr' => 'nullable|numeric|min:0',
            'ReceiptType' => 'required',
            'User' => 'required',
            'Description' => 'required',
            'Description' => 'required',

        ];
    }
}
