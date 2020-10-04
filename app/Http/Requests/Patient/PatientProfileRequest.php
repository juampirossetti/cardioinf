<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Patient;

class PatientProfileRequest extends FormRequest
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
        $rules = null;
        switch($this->method())
        {           
            case 'GET':
            case 'DELETE':
                {
                    $rules = [];
                }
            case 'POST':
                {
                    $rules = Patient::$rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                    $rules = Patient::$rules;
                }
            default:break;
        }

        unset($rules['name']);
        unset($rules['surname']);
        unset($rules['dni']);
        
        return $rules;
    }
}