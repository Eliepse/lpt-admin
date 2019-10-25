<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'firstname_zh' => 'sometimes|nullable|string|max:50',
            'lastname_zh' => 'sometimes|nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'wechat_id' => 'required|string|max:50',
            'phone' => 'sometimes|string|max:16',
            'address' => 'sometimes|nullable|string|max:150',
        ];
    }
}
