<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment;

class UpdateCalendarAppointmentRequest extends FormRequest
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
            'money' => 'numeric|nullable',
            'coupons' => 'numeric|min:0|max:10|nullable',
            'insurance' => 'string|max:60|nullable',
            'status' => 'numeric|min:0|max:4|required',
            'patient_id' => 'nullable|numeric|exists:patients,id'
        ];
    }
}