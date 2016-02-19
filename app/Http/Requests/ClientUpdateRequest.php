<?php

namespace TargetInk\Http\Requests;

use TargetInk\Http\Requests\Request;

class ClientUpdateRequest extends Request
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
            'name' => 'required|max:255',
            'web' => 'required|max:255',
            'password' => 'max:255',
            'email' => 'required|email|max:255|unique:users,email,' . request()->input('client_id'),
            'second_email' => 'email|max:255',
        ];
    }
}
