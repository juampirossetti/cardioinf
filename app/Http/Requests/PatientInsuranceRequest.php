<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PatientInsurance;

class PatientInsuranceRequest extends FormRequest
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
                    $rules = PatientInsurance::$rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                    $rules = PatientInsurance::$rules;
                }
            default:break;
        }

        return $rules;
    }
}