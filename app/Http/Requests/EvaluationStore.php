<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationStore extends FormRequest
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
        //unique:servers,ip,'.$this->id.',NULL,id,hostname,'.$request->input('hostname')
        return [
            'teacher_name' => 'required',
            'teacher_dpi'  => 'required|min:13|numeric|unique:evaluations,teacher_dpi,NULL,id,group_id,'.request()->group_id,
            'group_id'     => 'required|exists:groups,id'
        ];
    }

    public function messages()
    {
        return [
            'teacher_name.required' => 'El campo nombre es obligatorio.',
            'teacher_dpi.unique' => 'Ya existe una evaluación en este grupo con este dpi'
        ];
    }
}
