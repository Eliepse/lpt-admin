<?php

namespace App\Http\Requests;

use App\Enums\Days;
use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'location' => 'required|in:belleville,aubervilliers',
            'teacher' => 'required|nullable|exists:users,id',
            'price' => 'required|integer|min:0|max:65000',
            'max_students' => 'required|integer|min:1|max:250',
            'start_at' => 'required|date|before:end_at',
            'end_at' => 'required|date|after:start_at',
//            'timetable'    => 'required|regex:/^[1-7]-[0-23]$/',
            'timetable_day' => 'required|enum_key:' . Days::class,
            'timetable_hour' => 'required|date_format:H:i',
            'level' => 'required|integer|nullable|between:1,4',
            'courses' => 'required|array',
            'courses.*' => 'required|exists:courses,id',
        ];
    }
}
