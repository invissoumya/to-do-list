<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'first_name' => "required|max:100",
            'last_name' => "required|max:100",
            'email' => "required|max:100|email|unique:registrations",
            'password' => "required|min:8|max:25|confirmed",
            
        ];
    }
}
