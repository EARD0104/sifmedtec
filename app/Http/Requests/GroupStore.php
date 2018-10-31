<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStore extends FormRequest
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
            'school_id' => 'required|exists:schools,id',
            'month_id' => 'required|exists:months,id',
        ];
    }
}
