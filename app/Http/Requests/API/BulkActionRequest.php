<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class BulkActionRequest extends FormRequest
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
            'professional_id' => 'required|exists:professionals,id',
            'date_from' => 'required|date_format:Y-m-d',
            'date_until' => 'required|date_format:Y-m-d',
            'action' => 'required|string|in:delete,disable'
        ];
    }
}