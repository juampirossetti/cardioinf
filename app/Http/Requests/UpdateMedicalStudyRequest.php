<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MedicalStudy;

class UpdateMedicalStudyRequest extends FormRequest
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
        $id = $this->request->get('_id');
        
        $rules = MedicalStudy::$rules;
        
        $rules['name'] = $rules['name'] . ',' . $id;
        //dd($rules);
        return $rules;
    }
}
