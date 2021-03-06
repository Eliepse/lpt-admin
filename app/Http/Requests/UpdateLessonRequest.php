<?php

namespace App\Http\Requests;

use App\Enums\LessonCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:250',
            'category' => ['required', 'string', 'enum_key:' . LessonCategoryEnum::class,],
        ];
    }
}
