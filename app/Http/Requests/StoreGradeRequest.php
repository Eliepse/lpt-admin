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
            'teacher' => 'present|nullable|exists:users,id',
            'price' => 'required|integer|min:0|max:65000',
            'max_students' => 'required|integer|min:1|max:250',
            'first_day' => 'required|date|before:last_day',
            'last_day' => 'required|date|after:first_day',
//            'timetable'    => 'required|regex:/^[1-7]-[0-23]$/',
            'timetable_day' => 'required|enum_key:' . Days::class,
            'timetable_hour' => 'required|date_format:H:i',
            'booking_open_at' => 'required_with:booking_close_at|date|before:last_day|before:booking_close_at',
            'booking_close_at' => 'required_with:booking_open_at|date|before:last_day|after:booking_open_at',
            'level' => 'present|integer|nullable|between:1,4',
            'courses' => 'required|array',
            'courses.*' => 'required|exists:courses,id',
        ];
    }
}
