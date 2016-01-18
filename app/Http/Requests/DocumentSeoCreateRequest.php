<?php

namespace TargetInk\Http\Requests;

use TargetInk\Http\Requests\Request;

class DocumentSeoCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->admin) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|exists:users,id',
            'file' => 'required|mimes:pdf,doc,docx,doc,csv,jpeg,jpg,gif,png,txt',
            'filename' => 'required|max:255',
        ];
    }
}
