<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|max:50',
            'description' => 'required|string|max:250',
            'teacher'     => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    /** @var Builder $query */
                    $query->where('type', 'teacher');
                }),
            ],
            'category'    => 'required|string|in:language,art,activity',
            'duration'    => 'required|int|min:1|max:65000',
        ];
    }
}
