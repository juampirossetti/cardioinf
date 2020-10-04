<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TempReservation;

use Illuminate\Validation\Rule;

class CreateTempReservationRequest extends FormRequest
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
            'date' => 'nullable|date_format:Y-m-d',
            'time' => 'nullable|date_format:H:i',
            'medical_study_id' => 'sometimes|numeric|exists:medical_studies,id',
            'professional_id' => 'sometimes|numeric|exists:professionals,id'
        ];
    }
}