<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class deleteDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: check file age
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
            'DocumentID' => 'required|numeric|min:0',
            'FileID' => 'required|numeric|min:0',

        ];
    }
}
