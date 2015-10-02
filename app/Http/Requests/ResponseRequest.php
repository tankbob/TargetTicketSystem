<?php

namespace TargetInk\Http\Requests;

use TargetInk\Http\Requests\Request;

class ResponseRequest extends Request
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
        $rules = [
            'content' => 'required'
        ];

        for($i = 1; $i <= $this->get('attachment_count'); $i++){
            $rules['attachment-'.$i] = 'mimes:pdf,doc,docx,doc,csv,jpeg,jpg,gif,png,txt';
        }

        return $rules;
    }

    public function messages(){
        $messages = [];

        for($i = 1; $i <= $this->get('attachment_count'); $i++){
            $messages['attachment-'.$i.'.mimes'] = 'Please add attachment in the following file formats: pdf,docx,doc,csv,jpeg,gif,png,txt';
        }

        return $messages;
    }
}
