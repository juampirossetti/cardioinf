<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class IndicationRequest extends FormRequest
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
            'medical_study_id' => 'required|numeric|exists:medical_studies,id',
            'insurance_id' => 'required|numeric|exists:insurances,id',
        ];
    }
}