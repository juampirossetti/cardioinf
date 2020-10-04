<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Timetable;

class CreateTimetableRequest extends FormRequest
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
        return array_merge(
                    Timetable::$rules,[
                    'day' => 'numeric|min:0|max:7|required|unique_with:timetables,turn,professional_id'
                    ]);
    }
}
