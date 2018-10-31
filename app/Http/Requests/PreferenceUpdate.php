<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreferenceUpdate extends FormRequest
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
            'question_area' => 'required|min:0',
            'answers_question' => 'required|min:0',
            'number_capacitation_plan_1' => 'required|min:0',
            'number_capacitation_plan_2' => 'required|min:0',
            'number_capacitation_plan_3' => 'required|min:0',
            'number_capacitation_plan_4' => 'required|min:0',
        ];
    }
}
