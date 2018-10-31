<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use sifmedtec\Rules\CurrentPassword;

class PasswordRequest extends FormRequest
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
            'current_password' => ['required', new CurrentPassword()],
            'password' => 'required',
            'password_confirmation' => 'required|string|min:6|confirmed',
        ];
    }
}
