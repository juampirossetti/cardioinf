<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Indication;

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
                    $rules = Indication::$rules;
                }
            case 'PUT':
            case 'PATCH':
                {   
                    $id = $this->request->get('_id');
                    $rules = array_merge(
                        Indication::$rules,[
                            'insurance_id' => 'numeric|nullable|exists:insurances,id|unique_with:indications,medical_study_id,'.$id
                        ]);
                }
            default:break;
        }

        return $rules;
    }
}