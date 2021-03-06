<?php

namespace App\Http\Requests;

use App\Enums\LessonCategoryEnum;
use App\Sets\DaysSet;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isoDate = 'Y-m-d';

        return [
            "campus" => "required|exists:campuses,id",
            "course" => "required|exists:courses,id",
            "room" => "nullable|string|max:30",
            "day" => "required|string|in:" . join(",", DaysSet::getKeys()),
            "hour" => "required|date_format:H:i",
            'start_at' => "required|date_format:$isoDate",
            "end_at" => "required|date_format:$isoDate|after:start_at",
            "signup_start_at" => "nullable|date:$isoDate|before:start_at",
            "signup_end_at" => "nullable|date:$isoDate|before:start_at|after:signup_start_at",
            "price" => "required|integer|between:0,65000",
            "max_students" => "required|integer|max:250",
            "teachers" => "array|exists:users,id",
        ];
    }
}
