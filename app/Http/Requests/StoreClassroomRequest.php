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
            'name' => 'required|string|max:50',
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|min:1|exists:lessons,id',
            'lessons.*.duration' => 'required|integer|between:0,65000',
        ];
    }
}
