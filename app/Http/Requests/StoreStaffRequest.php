<?php

namespace App\Http\Requests;

use App\Sets\UserRolesSet;
use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|array|in:' . join(',', UserRolesSet::getKeys()),
            'wechat_id' => 'required|string|max:50',
            'phone' => 'required|string|max:16',
            'address' => 'required|string|max:150',
        ];
    }
}
