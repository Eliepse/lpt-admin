<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreParentController extends FormRequest
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
        $email_unique = Rule::unique('users', 'email');

        /** @var User|mixed $parent */
        $parent = $this->route('parent');

        if (is_a($parent, User::class) && $this->isMethod('put')) {
            $email_unique->ignoreModel($parent);
        }

        return [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                $email_unique,
            ],
            'type' => 'nullable|in:admin,teacher,parent',
            'wechat_id' => 'nullable|string|max:20',
            'phone' => 'required|string|max:16',
            'address' => 'required|string|max:150',
        ];
    }
}
