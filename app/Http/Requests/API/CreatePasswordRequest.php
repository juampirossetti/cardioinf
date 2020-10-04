<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Patient;

class CreatePasswordRequest extends FormRequest
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
        $patient_id = $this->request->get('patient_id');
        
        $user_id = Patient::find($patient_id)->user->id;

        return [
           'email' => 'required|email|unique:users,email,'.$user_id,
           'patient_id' => 'required|exists:patients,id'
        ];
    }
}