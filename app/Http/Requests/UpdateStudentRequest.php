<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'sometimes|string|max:50',
            'lastname' => 'sometimes|string|max:50',
            'firstname_zh' => 'sometimes|nullable|string|max:50',
            'lastname_zh' => 'sometimes|nullable|string|max:50',
            'birthday' => 'sometimes|before:today',
            'notes' => 'sometimes|nullable|string|max:65000',
        ];
    }
}
