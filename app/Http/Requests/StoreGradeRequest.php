<?php

namespace App\Http\Requests;

use App\Enums\DaysEnum;
use App\Enums\LocationEnum;
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
            'location' => ['required', 'enum_key:' . LocationEnum::class],
            'teacher' => 'present|nullable|exists:users,id',
            'price' => 'required|integer|min:0|max:65000',
            'max_students' => 'required|integer|min:1|max:250',
            'level' => 'present|integer|nullable|between:1,4',
            'courses' => 'required|array',
            'courses.*' => 'required|exists:lessons,id',
        ];
    }
}
