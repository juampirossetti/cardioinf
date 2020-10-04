<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentDisponibilityRequest extends FormRequest
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
            'medical_study_id' => 'nullable|numeric|exists:medical_studies,id'
            //'professional_id' => 'required|numeric|exists:professionals,id',
        ];
    }
}