<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Parent
            'parent.firstname' => 'required|string|max:50',
            'parent.lastname' => 'required|string|max:50',
            'parent.email' => 'required|email',
            'parent.wechat_id' => 'required|string|max:50',
            'parent.phone' => 'required|string|max:16',
            'parent.address' => 'nullable|string|max:150',
            // Student
            'student.firstname' => 'required|string|max:50',
            'student.lastname' => 'required|string|max:50',
            'student.birthday' => 'required|date_format:Y-m-d|before:today',
            'student.notes' => 'nullable|string|max:1000',
        ];
    }
}
