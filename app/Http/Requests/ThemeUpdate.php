<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeUpdate extends FormRequest
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
        $theme = $this->route()->parameter('theme');
        return [
            'name' => 'required|unique:themes,name,'.$theme->id,
            'area_id' => 'required|exists:areas,id'
        ];
    }
}
