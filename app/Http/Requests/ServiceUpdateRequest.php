<?php

namespace TargetInk\Http\Requests;

use TargetInk\Http\Requests\Request;

class ServiceUpdateRequest extends Request
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
            'client_id' => 'required|exists:users',
            'icon' => 'required|image',
            'icon_rollover' => 'required|image',
            'heading' => 'required|max:255',
            'link' => 'required|url|max:255',
            'text' => '',
        ];
    }
}
