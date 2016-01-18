<?php

namespace TargetInk\Http\Requests;

use TargetInk\Http\Requests\Request;

class AdvertCreateRequest extends Request
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
            'image' => 'required|image',
            'url' => 'required|url|max:255',
            'name' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Please select a client first!'
        ];
    }
}
