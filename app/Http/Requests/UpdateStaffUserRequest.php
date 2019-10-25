<?php

namespace App\Http\Requests;

use App\Sets\UserRolesSet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffUserRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignoreModel($this->route('staff')),
            ],
            'roles' => 'required|array|in:' . join(',', UserRolesSet::getKeys()),
            'wechat_id' => 'required|string|max:50',
            'phone' => 'required|string|max:16',
            'address' => 'nullable|string|max:150',
        ];
    }
}
