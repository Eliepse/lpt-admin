<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckStudentAttendanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'state' => 'required|in:present,absent,late',
            'referred_date' => 'required|date:Y-m-d',
            'comment' => 'sometimes|nullable|string|max:255',
        ];
    }
}
