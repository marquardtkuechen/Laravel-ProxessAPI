<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class getDocumentFileRequest extends FormRequest
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
            'FileID'       => 'nullable|numeric|min:0'
        ];
    }
}
