<?php

namespace App\Http\Requests;

use App\ClientUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var ClientUser $parent */
        $parent = $this->route('parent');

        return [
            'firstname' => 'sometimes|string|max:50',
            'lastname' => 'sometimes|string|max:50',
            'firstname_zh' => 'sometimes|nullable|string|max:50',
            'lastname_zh' => 'sometimes|nullable|string|max:50',
            'email' => [
                'sometimes', 'email', Rule::unique('users', 'email')->ignoreModel($parent, 'email'),
            ],
            'wechat_id' => 'sometimes|string|max:50',
            'phone' => 'sometimes|string|max:16',
            'address' => 'sometimes|nullable|string|max:150',
        ];
    }
}
