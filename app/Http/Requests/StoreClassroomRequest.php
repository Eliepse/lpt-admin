<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Rules\TimetableRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
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
            'name' => 'sometimes|nullable|string|max:50',
            'location' => ['required', 'enum_key:' . LocationEnum::class],
            'max_students' => 'required|integer|min:1|max:250',
            'timetables' => ['required', 'json', new TimetableRule(true)],
            'first_day' => 'required|date|before:last_day',
            'last_day' => 'required|date|after:first_day',
            'booking_open_at' => 'sometimes|nullable|date|before:last_day|before:last_day',
            'booking_close_at' => 'sometimes|nullable|date|after:first_day|before:last_day',
        ];
    }
}
