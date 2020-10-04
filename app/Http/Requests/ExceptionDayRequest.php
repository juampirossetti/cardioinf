<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\ExceptionDay;

class ExceptionDayRequest extends FormRequest
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
                    $rules = ExceptionDay::$rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                    $id = $this->request->get('_id');
                    //$rules = ExceptionDay::$rules;
                    $rules = array_merge(
                        ExceptionDay::$rules,[
                            'professional_id' => 'numeric|exists:professionals,id|unique_with:exceptions_days,date,'.$id
                        ]);
                }
            default:break;
        }

        return $rules;
    }
}