<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolUpdate extends FormRequest
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
        $school = $this->route()->parameter('school');
        return [
            'name'            => 'required|unique:schools,name,'.$school->id,
            'city_id'         => 'required|exists:cities,id',
            'principal_name'  => 'required',
            'principal_phone' => 'required',
            'principal_email' => 'required',
            'phone'           => 'required',
            'other_phone'     => 'nullable',
            'teachers'        => 'nullable',
            'email'           => 'nullable|email',
        ];
    }
}
