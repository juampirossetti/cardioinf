<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TempReservation;

use Illuminate\Validation\Rule;

class CreateAppointmentReservationRequest extends FormRequest
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
            'id' => 'required|exists:appointments,id',
            'reserve' => 'required|boolean',
            'professional_id' => 'required|numeric|exists:professionals,id',
        ];
    }
}