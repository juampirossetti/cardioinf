<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Professional;

class CreateProfessionalPasswordRequest extends FormRequest
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
        $professional_id = $this->request->get('professional_id');
        
        $professional = Professional::find($professional_id);

        $user_id = ($professional->user != null ) ? $professional->user->id : null;

        return [
           'email' => 'required|email|unique:users,email,'.$user_id,
           'professional_id' => 'required|exists:professionals,id'
        ];
    }
}