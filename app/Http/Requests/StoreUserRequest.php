<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'firstname_zh' => 'sometimes|nullable|string|max:50',
            'lastname_zh' => 'sometimes|nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'sometimes|string|min:8|max:64',
            'type' => 'nullable|in:staff,parent',
            'wechat_id' => 'nullable|string|max:20',
            'phone' => 'required|string|max:16',
            'address' => 'required|string|max:150',
        ];
    }
}
