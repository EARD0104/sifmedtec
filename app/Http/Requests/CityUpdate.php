<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityUpdate extends FormRequest
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
        $city = $this->route()->parameter('city');
        return [
            'name' => 'required|unique:cities,name,'.$city->id,
            'department_id' => 'required|exists:departments,id'
        ];
    }
}
