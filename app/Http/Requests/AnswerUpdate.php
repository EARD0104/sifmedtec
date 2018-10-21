<?php

namespace sifmedtec\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerUpdate extends FormRequest
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
        $answer = $this->route()->parameter('answer');
        return [
            'name' => 'required|unique:answers,name,'.$answer->id,
            'question_id' => 'required|exists:questions,id'
        ];
    }
}
