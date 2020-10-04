<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\History;

class UpdateHistoryRequest extends FormRequest
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
        return array_merge(
            History::$rules,[
             'professional_id' => 'string|exists:professionals,id|unique_with:histories,patient_id,'.$id
        ]);
    }
}
